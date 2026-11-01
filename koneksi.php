<?php
// ============================================================
// koneksi.php — Koneksi Database PDO
// Letakkan file ini di root project (sejajar index.php)
// ============================================================

define('DB_HOST', 'localhost');
define('DB_NAME', 'budi_percetakan');
define('DB_USER', 'root');       // Ganti sesuai user MySQL Anda
define('DB_PASS', '');           // Ganti sesuai password MySQL Anda
define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            DB_HOST, DB_NAME, DB_CHARSET
        );
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Produksi: log error, jangan tampilkan ke user
            http_response_code(500);
            die(json_encode(['error' => 'Koneksi database gagal.']));
        }
    }
    return $pdo;
}

// Helper: generate kode pesanan unik
function generateKodePesanan(): string {
    $prefix = 'BP-' . date('Ymd') . '-';
    $db = getDB();
    $stmt = $db->prepare(
        "SELECT kode_pesanan FROM pesanan
         WHERE kode_pesanan LIKE :prefix
         ORDER BY id DESC LIMIT 1"
    );
    $stmt->execute([':prefix' => $prefix . '%']);
    $last = $stmt->fetchColumn();
    $seq  = $last ? (int)substr($last, -4) + 1 : 1;
    return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
}
