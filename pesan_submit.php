<?php
// api/pesan_submit.php — Submit pesanan baru dari pelanggan (POST)
require_once '../koneksi.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan.']);
    exit;
}

// ── Sanitasi input ──
$nama    = trim($_POST['nama']     ?? '');
$wa      = trim($_POST['whatsapp'] ?? '');
$alamat  = trim($_POST['alamat']   ?? '');
$id_bahan= (int)($_POST['id_bahan']?? 0);
$panjang = (float)($_POST['panjang']?? 0);
$lebar   = (float)($_POST['lebar']  ?? 0);
$jumlah  = (int)($_POST['jumlah']  ?? 1);
$catatan = trim($_POST['catatan']  ?? '');

// ── Validasi ──
$errors = [];
if (mb_strlen($nama) < 2)                           $errors[] = 'Nama minimal 2 karakter.';
if (!preg_match('/^[0-9+\-\s]{8,20}$/', $wa))       $errors[] = 'Nomor WhatsApp tidak valid.';
if (mb_strlen($alamat) < 5)                         $errors[] = 'Alamat harus diisi.';
if ($id_bahan <= 0)                                 $errors[] = 'Pilih jenis bahan.';
if ($panjang <= 0 || $panjang > 9999)               $errors[] = 'Panjang tidak valid.';
if ($lebar   <= 0 || $lebar   > 9999)               $errors[] = 'Lebar tidak valid.';
if ($jumlah  <= 0 || $jumlah  > 9999)               $errors[] = 'Jumlah tidak valid.';

if ($errors) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

$db = getDB();

// ── Cek bahan ──
$sb = $db->prepare("SELECT id, harga_per_m2 FROM bahan_spanduk WHERE id=? AND aktif=1");
$sb->execute([$id_bahan]);
$bahan = $sb->fetch();
if (!$bahan) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Jenis bahan tidak ditemukan.']);
    exit;
}

// ── Handle upload file desain ──
$file_desain = null;
if (!empty($_FILES['file_desain']['name'])) {
    $file   = $_FILES['file_desain'];
    $allowed_types = ['image/jpeg','image/jpg','image/png','image/gif','image/webp','application/pdf'];
    $max_size      = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowed_types)) {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'File harus berupa gambar (JPG/PNG/WEBP/GIF) atau PDF, maks 5MB.']);
        exit;
    }
    if ($file['size'] > $max_size) {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'Ukuran file maksimal 5MB.']);
        exit;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        http_response_code(422);
        echo json_encode(['success' => false, 'message' => 'Upload gagal, coba lagi.']);
        exit;
    }

    $upload_dir = __DIR__ . '/../uploads/desain/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $ext         = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $file_desain = 'desain_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $dest        = $upload_dir . $file_desain;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan file. Cek permission folder uploads/desain/']);
        exit;
    }
}

// ── Hitung total & simpan ──
$harga_m2 = (float)$bahan['harga_per_m2'];
$total    = $panjang * $lebar * $harga_m2 * $jumlah;
$kode     = generateKodePesanan();

$ins = $db->prepare(
    "INSERT INTO pesanan
        (kode_pesanan, nama_pelanggan, no_whatsapp, alamat, id_bahan,
         panjang, lebar, jumlah, catatan_desain, file_desain,
         harga_satuan_m2, total_harga, status)
     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,'Menunggu')"
);
$ins->execute([
    $kode, $nama, $wa, $alamat, $id_bahan,
    $panjang, $lebar, $jumlah, $catatan, $file_desain,
    $harga_m2, $total
]);

echo json_encode([
    'success'      => true,
    'message'      => 'Pesanan berhasil dikirim!',
    'kode_pesanan' => $kode,
    'total_harga'  => $total,
]);
