<?php
// admin/api/update_status.php — Update status pesanan
session_start();
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}
require_once '../../koneksi.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$id      = (int)($_POST['id']           ?? 0);
$status  = trim($_POST['status']        ?? '');
$catatan = trim($_POST['catatan_admin'] ?? '');

$allowed = ['Menunggu','Diproses','Selesai','Dibatalkan'];
if (!$id || !in_array($status, $allowed)) {
    http_response_code(422);
    echo json_encode(['error' => 'Data tidak valid.']);
    exit;
}

$db = getDB();

// Ambil data pesanan lengkap untuk generate link WA
$fetch = $db->prepare(
    "SELECT p.*, b.nama_bahan
     FROM pesanan p
     JOIN bahan_spanduk b ON b.id = p.id_bahan
     WHERE p.id = ?"
);
$fetch->execute([$id]);
$pesanan = $fetch->fetch();

if (!$pesanan) {
    http_response_code(404);
    echo json_encode(['error' => 'Pesanan tidak ditemukan.']);
    exit;
}

// Simpan status baru
$upd = $db->prepare("UPDATE pesanan SET status=?, catatan_admin=? WHERE id=?");
$upd->execute([$status, $catatan, $id]);

// Kembalikan data pesanan lengkap (untuk generate link WA di frontend)
$pesanan['catatan_admin'] = $catatan;
$pesanan['status']        = $status;

echo json_encode([
    'success' => true,
    'message' => "Status diperbarui menjadi \"$status\".",
    'pesanan' => $pesanan,
]);
