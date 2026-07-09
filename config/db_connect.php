<?php
/**
 * Database Connection (PDO)
 * Koneksi ke MySQL menggunakan PDO dengan UTF-8 support untuk teks Arab
 */

// ============================================================
// Konfigurasi Database
// ============================================================
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'panduan_sholat');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// ============================================================
// Singleton PDO Connection
// ============================================================
function getDB($silent = false) {
    static $pdo = null;

    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET,
            PDO::ATTR_TIMEOUT            => 2,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            if ($silent) {
                throw $e;
            }
            // Dalam produksi, log error, jangan tampilkan detail
            error_log("Database Connection Error: " . $e->getMessage());
            die('<div style="text-align:center;padding:40px;font-family:sans-serif;">
                    <h2 style="color:#ef4444;">⚠️ Koneksi Database Gagal</h2>
                    <p style="color:#666;">Pastikan MySQL sudah berjalan dan database <code>panduan_sholat</code> sudah dibuat.</p>
                    <p style="color:#999;font-size:14px;">Import file <code>config/database.sql</code> ke phpMyAdmin terlebih dahulu.</p>
                 </div>');
        }
    }

    return $pdo;
}

/**
 * Helper: Check apakah database tersedia
 * @return bool
 */
function isDatabaseAvailable() {
    try {
        $pdo = getDB(true);
        $stmt = $pdo->query("SELECT 1 FROM gerakan_sholat LIMIT 1");
        return $stmt !== false;
    } catch (Exception $e) {
        return false;
    }
}
