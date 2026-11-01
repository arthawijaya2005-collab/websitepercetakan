<?php
// admin/api/pesanan_list.php — Daftar pesanan + filter + pagination
session_start();
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}
require_once '../../koneksi.php';
header('Content-Type: application/json; charset=utf-8');

$db     = getDB();
$status = $_GET['status'] ?? 'semua';
$search = trim($_GET['search'] ?? '');
$page   = max(1, (int)($_GET['page'] ?? 1));
$limit  = 10;
$offset = ($page - 1) * $limit;

$where  = ['1=1'];
$params = [];

if ($status !== 'semua') {
    $where[]  = 'p.status = ?';
    $params[] = $status;
}
if ($search) {
    $where[]  = '(p.nama_pelanggan LIKE ? OR p.kode_pesanan LIKE ? OR p.no_whatsapp LIKE ?)';
    $s = "%$search%";
    array_push($params, $s, $s, $s);
}

$whereSQL = implode(' AND ', $where);

// Count
$cnt   = $db->prepare("SELECT COUNT(*) FROM pesanan p WHERE $whereSQL");
$cnt->execute($params);
$total = (int)$cnt->fetchColumn();

// Rows
$stmt = $db->prepare(
    "SELECT p.*, b.nama_bahan,
            (p.panjang * p.lebar) as luas_m2
     FROM pesanan p
     JOIN bahan_spanduk b ON b.id = p.id_bahan
     WHERE $whereSQL
     ORDER BY p.created_at DESC
     LIMIT $limit OFFSET $offset"
);
$stmt->execute($params);
$rows = $stmt->fetchAll();

echo json_encode([
    'total'      => $total,
    'page'       => $page,
    'last_page'  => max(1, (int)ceil($total / $limit)),
    'data'       => $rows,
]);
