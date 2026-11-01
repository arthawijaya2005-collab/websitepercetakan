<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}
require_once '../../koneksi.php';
header('Content-Type: application/json; charset=utf-8');

$db    = getDB();
$today = date('Y-m-d');
$bulan = date('Y-m');

// ── Helper: query single value ──
function qVal(PDO $db, string $sql, array $p = []): float {
    $s = $db->prepare($sql);
    $s->execute($p);
    return (float)$s->fetchColumn();
}
function qRow(PDO $db, string $sql, array $p = []): array {
    $s = $db->prepare($sql);
    $s->execute($p);
    return $s->fetch() ?: [];
}

// ══════════════════════════════════════
// METRIK HARIAN (hari ini)
// ══════════════════════════════════════
$pend_hari   = qVal($db, "SELECT COALESCE(SUM(total_harga),0) FROM pesanan WHERE DATE(created_at)=? AND status='Selesai'", [$today]);
$luas_hari   = qVal($db, "SELECT COALESCE(SUM(panjang*lebar*jumlah),0) FROM pesanan WHERE DATE(created_at)=? AND status='Selesai'", [$today]);
$pcs_hari    = (int)qVal($db, "SELECT COALESCE(SUM(jumlah),0) FROM pesanan WHERE DATE(created_at)=? AND status='Selesai'", [$today]);
$trx_hari    = (int)qVal($db, "SELECT COUNT(*) FROM pesanan WHERE DATE(created_at)=? AND status!='Dibatalkan'", [$today]);
$batal_hari  = qRow($db, "SELECT COUNT(*) as jml, COALESCE(SUM(total_harga),0) as nilai FROM pesanan WHERE DATE(created_at)=? AND status='Dibatalkan'", [$today]);

// ══════════════════════════════════════
// METRIK BULANAN (bulan ini)
// ══════════════════════════════════════
$pend_bulan  = qVal($db, "SELECT COALESCE(SUM(total_harga),0) FROM pesanan WHERE DATE_FORMAT(created_at,'%Y-%m')=? AND status='Selesai'", [$bulan]);
$luas_bulan  = qVal($db, "SELECT COALESCE(SUM(panjang*lebar*jumlah),0) FROM pesanan WHERE DATE_FORMAT(created_at,'%Y-%m')=? AND status='Selesai'", [$bulan]);
$pcs_bulan   = (int)qVal($db, "SELECT COALESCE(SUM(jumlah),0) FROM pesanan WHERE DATE_FORMAT(created_at,'%Y-%m')=? AND status='Selesai'", [$bulan]);
$trx_bulan   = (int)qVal($db, "SELECT COUNT(*) FROM pesanan WHERE DATE_FORMAT(created_at,'%Y-%m')=? AND status!='Dibatalkan'", [$bulan]);
$batal_bulan = qRow($db, "SELECT COUNT(*) as jml, COALESCE(SUM(total_harga),0) as nilai FROM pesanan WHERE DATE_FORMAT(created_at,'%Y-%m')=? AND status='Dibatalkan'", [$bulan]);

// ══════════════════════════════════════
// CHART HARIAN — 30 hari terakhir
// ══════════════════════════════════════
$r_daily = $db->query(
    "SELECT DATE(created_at) as tgl,
            COALESCE(SUM(total_harga),0) as pendapatan,
            COALESCE(SUM(panjang*lebar*jumlah),0) as luas,
            COUNT(*) as trx
     FROM pesanan
     WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 29 DAY)
       AND status = 'Selesai'
     GROUP BY DATE(created_at)
     ORDER BY tgl ASC"
);
$daily_raw = $r_daily->fetchAll();
$daily = [];
for ($i = 29; $i >= 0; $i--) {
    $d = date('Y-m-d', strtotime("-$i days"));
    $daily[$d] = ['pendapatan' => 0, 'luas' => 0, 'trx' => 0];
}
foreach ($daily_raw as $row) {
    $daily[$row['tgl']] = [
        'pendapatan' => (float)$row['pendapatan'],
        'luas'       => round((float)$row['luas'], 2),
        'trx'        => (int)$row['trx'],
    ];
}

// ══════════════════════════════════════
// CHART BULANAN — 12 bulan terakhir
// ══════════════════════════════════════
$r_monthly = $db->query(
    "SELECT DATE_FORMAT(created_at,'%Y-%m') as bln,
            COALESCE(SUM(total_harga),0) as pendapatan,
            COALESCE(SUM(panjang*lebar*jumlah),0) as luas,
            COUNT(*) as trx
     FROM pesanan
     WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 11 MONTH)
       AND status = 'Selesai'
     GROUP BY DATE_FORMAT(created_at,'%Y-%m')
     ORDER BY bln ASC"
);
$monthly_raw = $r_monthly->fetchAll();
$monthly = [];
for ($i = 11; $i >= 0; $i--) {
    $m = date('Y-m', strtotime("-$i months"));
    $monthly[$m] = ['pendapatan' => 0, 'luas' => 0, 'trx' => 0];
}
foreach ($monthly_raw as $row) {
    $monthly[$row['bln']] = [
        'pendapatan' => (float)$row['pendapatan'],
        'luas'       => round((float)$row['luas'], 2),
        'trx'        => (int)$row['trx'],
    ];
}

// ══════════════════════════════════════
// TABEL RINGKASAN HARIAN — 30 hari
// ══════════════════════════════════════
$r_tbl = $db->query(
    "SELECT
        DATE(created_at) as tgl,
        COALESCE(SUM(CASE WHEN status='Selesai' THEN total_harga ELSE 0 END),0)        as pendapatan,
        COALESCE(SUM(CASE WHEN status='Dibatalkan' THEN total_harga ELSE 0 END),0)     as kerugian,
        COUNT(CASE WHEN status='Selesai' THEN 1 END)                                   as trx_selesai,
        COUNT(CASE WHEN status='Dibatalkan' THEN 1 END)                                as trx_batal,
        COALESCE(SUM(CASE WHEN status='Selesai' THEN panjang*lebar*jumlah ELSE 0 END),0) as luas
     FROM pesanan
     WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 29 DAY)
     GROUP BY DATE(created_at)
     ORDER BY tgl DESC"
);
$tabel_harian = $r_tbl->fetchAll();

// ══════════════════════════════════════
// TABEL RINGKASAN BULANAN — 12 bulan
// ══════════════════════════════════════
$r_tblm = $db->query(
    "SELECT
        DATE_FORMAT(created_at,'%Y-%m') as bln,
        COALESCE(SUM(CASE WHEN status='Selesai' THEN total_harga ELSE 0 END),0)        as pendapatan,
        COALESCE(SUM(CASE WHEN status='Dibatalkan' THEN total_harga ELSE 0 END),0)     as kerugian,
        COUNT(CASE WHEN status='Selesai' THEN 1 END)                                   as trx_selesai,
        COUNT(CASE WHEN status='Dibatalkan' THEN 1 END)                                as trx_batal,
        COALESCE(SUM(CASE WHEN status='Selesai' THEN panjang*lebar*jumlah ELSE 0 END),0) as luas
     FROM pesanan
     WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 11 MONTH)
     GROUP BY DATE_FORMAT(created_at,'%Y-%m')
     ORDER BY bln DESC"
);
$tabel_bulanan = $r_tblm->fetchAll();

echo json_encode([
    // Metrik harian
    'pendapatan'       => $pend_hari,
    'keuntungan'       => $pend_hari * 0.35,
    'luas_terjual'     => round($luas_hari, 2),
    'pcs_terjual'      => $pcs_hari,
    'total_transaksi'  => $trx_hari,
    'kerugian_jml'     => (int)($batal_hari['jml'] ?? 0),
    'kerugian_nilai'   => (float)($batal_hari['nilai'] ?? 0),

    // Metrik bulanan
    'pend_bulan'       => $pend_bulan,
    'untung_bulan'     => $pend_bulan * 0.35,
    'luas_bulan'       => round($luas_bulan, 2),
    'pcs_bulan'        => $pcs_bulan,
    'trx_bulan'        => $trx_bulan,
    'batal_bulan_jml'  => (int)($batal_bulan['jml'] ?? 0),
    'batal_bulan_nilai'=> (float)($batal_bulan['nilai'] ?? 0),

    // Chart data
    'chart_daily'      => array_values($daily),
    'chart_daily_lbl'  => array_keys($daily),
    'chart_monthly'    => array_values($monthly),
    'chart_monthly_lbl'=> array_keys($monthly),

    // Tabel histori
    'tabel_harian'     => $tabel_harian,
    'tabel_bulanan'    => $tabel_bulanan,
]);
