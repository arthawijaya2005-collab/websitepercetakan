<?php
// api/antrian.php — API endpoint untuk data antrean (publik, read-only)
// Diakses via Fetch API dari pesan.php
require_once '../koneksi.php';
header('Content-Type: application/json; charset=utf-8');

$db = getDB();

// Ambil 15 pesanan terbaru, sembunyikan nama (J***n)
$stmt = $db->query(
    "SELECT
        p.kode_pesanan,
        p.nama_pelanggan,
        b.nama_bahan,
        (p.panjang * p.lebar) AS luas_m2,
        p.jumlah,
        p.status,
        p.created_at
     FROM pesanan p
     JOIN bahan_spanduk b ON b.id = p.id_bahan
     WHERE p.status IN ('Menunggu','Diproses','Selesai')
     ORDER BY p.created_at DESC
     LIMIT 15"
);
$rows = $stmt->fetchAll();

// Samarkan nama: huruf pertama + *** + huruf terakhir
$result = array_map(function($r) {
    $name = $r['nama_pelanggan'];
    $masked = mb_substr($name, 0, 1)
        . str_repeat('*', max(3, mb_strlen($name) - 2))
        . mb_substr($name, -1);
    return [
        'kode'       => $r['kode_pesanan'],
        'nama'       => $masked,
        'bahan'      => $r['nama_bahan'],
        'luas'       => round((float)$r['luas_m2'], 2),
        'jumlah'     => (int)$r['jumlah'],
        'status'     => $r['status'],
        'created_at' => $r['created_at'],
    ];
}, $rows);

echo json_encode(['success' => true, 'data' => $result]);
