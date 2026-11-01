<?php
// api/edit_pesanan.php — Pelanggan edit pesanan via kode + nomor WA (POST)
require_once '../koneksi.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan.']);
    exit;
}

$action = trim($_POST['action'] ?? '');  // 'cek' | 'simpan'

// ──────────────────────────────────────────
// ACTION: CEK — verifikasi kode + nomor WA
// ──────────────────────────────────────────
if ($action === 'cek') {
    $kode = strtoupper(trim($_POST['kode'] ?? ''));
    $wa   = trim($_POST['whatsapp']        ?? '');

    if (!$kode || !$wa) {
        echo json_encode(['success' => false, 'message' => 'Kode pesanan dan nomor WA wajib diisi.']);
        exit;
    }

    $db   = getDB();
    $stmt = $db->prepare(
        "SELECT p.*, b.nama_bahan, b.harga_per_m2
         FROM pesanan p
         JOIN bahan_spanduk b ON b.id = p.id_bahan
         WHERE p.kode_pesanan = ?"
    );
    $stmt->execute([$kode]);
    $pesanan = $stmt->fetch();

    if (!$pesanan) {
        echo json_encode(['success' => false, 'message' => 'Kode pesanan tidak ditemukan.']);
        exit;
    }

    // Cocokan nomor WA (normalkan 08xx → 628xx untuk perbandingan)
    $normalizeWA = function($n) {
        $n = preg_replace('/\D/', '', $n);
        if (str_starts_with($n, '0')) $n = '62' . substr($n, 1);
        return $n;
    };
    if ($normalizeWA($pesanan['no_whatsapp']) !== $normalizeWA($wa)) {
        echo json_encode(['success' => false, 'message' => 'Nomor WhatsApp tidak cocok dengan pesanan ini.']);
        exit;
    }

    // Hanya bisa edit jika status Menunggu
    if ($pesanan['status'] !== 'Menunggu') {
        echo json_encode([
            'success' => false,
            'message' => "Pesanan dengan status \"{$pesanan['status']}\" tidak dapat diedit. Hubungi toko untuk perubahan.",
        ]);
        exit;
    }

    // Ambil semua bahan untuk dropdown
    $bahan = $db->query("SELECT id, nama_bahan, harga_per_m2 FROM bahan_spanduk WHERE aktif=1 ORDER BY urutan")->fetchAll();

    echo json_encode([
        'success' => true,
        'pesanan' => $pesanan,
        'bahan'   => $bahan,
    ]);
    exit;
}

// ──────────────────────────────────────────
// ACTION: SIMPAN — update data pesanan
// ──────────────────────────────────────────
if ($action === 'simpan') {
    $id      = (int)($_POST['id']       ?? 0);
    $wa_ver  = trim($_POST['wa_ver']    ?? '');  // WA untuk verifikasi ulang
    $id_bahan= (int)($_POST['id_bahan'] ?? 0);
    $panjang = (float)($_POST['panjang']?? 0);
    $lebar   = (float)($_POST['lebar']  ?? 0);
    $jumlah  = (int)($_POST['jumlah']   ?? 1);
    $catatan = trim($_POST['catatan']   ?? '');
    $alamat  = trim($_POST['alamat']    ?? '');

    $errors = [];
    if ($id <= 0)                                 $errors[] = 'ID pesanan tidak valid.';
    if ($id_bahan <= 0)                           $errors[] = 'Pilih jenis bahan.';
    if ($panjang <= 0 || $panjang > 9999)         $errors[] = 'Panjang tidak valid.';
    if ($lebar   <= 0 || $lebar   > 9999)         $errors[] = 'Lebar tidak valid.';
    if ($jumlah  <= 0 || $jumlah  > 9999)         $errors[] = 'Jumlah tidak valid.';
    if (mb_strlen($alamat) < 5)                   $errors[] = 'Alamat harus diisi.';

    if ($errors) {
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit;
    }

    $db = getDB();

    // Verifikasi pesanan + status
    $cek = $db->prepare("SELECT p.*, b.harga_per_m2 FROM pesanan p JOIN bahan_spanduk b ON b.id=p.id_bahan WHERE p.id=?");
    $cek->execute([$id]);
    $pesanan = $cek->fetch();
    if (!$pesanan || $pesanan['status'] !== 'Menunggu') {
        echo json_encode(['success' => false, 'message' => 'Pesanan tidak dapat diedit.']);
        exit;
    }

    // Verifikasi WA ulang
    $normalizeWA = fn($n) => ltrim(preg_replace('/\D/', '', $n), '0');
    if ($normalizeWA($pesanan['no_whatsapp']) !== $normalizeWA($wa_ver)) {
        echo json_encode(['success' => false, 'message' => 'Verifikasi WA gagal.']);
        exit;
    }

    // Ambil harga bahan baru
    $sb = $db->prepare("SELECT harga_per_m2 FROM bahan_spanduk WHERE id=? AND aktif=1");
    $sb->execute([$id_bahan]);
    $harga_m2 = (float)($sb->fetchColumn() ?: $pesanan['harga_per_m2']);

    $total = $panjang * $lebar * $harga_m2 * $jumlah;

    // Handle file baru (opsional)
    $file_desain = $pesanan['file_desain']; // default: file lama
    if (!empty($_FILES['file_desain']['name'])) {
        $file          = $_FILES['file_desain'];
        $allowed_types = ['image/jpeg','image/jpg','image/png','image/gif','image/webp','application/pdf'];
        if (!in_array($file['type'], $allowed_types) || $file['size'] > 5*1024*1024) {
            echo json_encode(['success' => false, 'message' => 'File tidak valid (JPG/PNG/WEBP/PDF, maks 5MB).']);
            exit;
        }
        $upload_dir = __DIR__ . '/../uploads/desain/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        // Hapus file lama
        if ($pesanan['file_desain'] && file_exists($upload_dir . $pesanan['file_desain'])) {
            @unlink($upload_dir . $pesanan['file_desain']);
        }
        $ext         = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $file_desain = 'desain_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        if (!move_uploaded_file($file['tmp_name'], $upload_dir . $file_desain)) {
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan file.']);
            exit;
        }
    }

    // Hapus file lama jika diminta
    if (!empty($_POST['hapus_file']) && $_POST['hapus_file'] === '1' && $pesanan['file_desain']) {
        $upload_dir = __DIR__ . '/../uploads/desain/';
        @unlink($upload_dir . $pesanan['file_desain']);
        $file_desain = null;
    }

    $upd = $db->prepare(
        "UPDATE pesanan SET
            id_bahan=?, panjang=?, lebar=?, jumlah=?,
            catatan_desain=?, file_desain=?, alamat=?,
            harga_satuan_m2=?, total_harga=?
         WHERE id=?"
    );
    $upd->execute([$id_bahan, $panjang, $lebar, $jumlah, $catatan, $file_desain, $alamat, $harga_m2, $total, $id]);

    echo json_encode([
        'success'      => true,
        'message'      => 'Pesanan berhasil diperbarui!',
        'total_harga'  => $total,
        'kode_pesanan' => $pesanan['kode_pesanan'],
    ]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Action tidak dikenali.']);
