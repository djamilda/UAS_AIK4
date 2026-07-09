<?php
// import_database_simple.php — Import all SQL statements from config/database.sql in one pass.

$sqlFile = __DIR__ . '/config/database.sql';
if (!file_exists($sqlFile)) {
    die('File SQL tidak ditemukan: ' . $sqlFile . PHP_EOL);
}

$sqlContent = file_get_contents($sqlFile);
if ($sqlContent === false) {
    die('Gagal membaca file SQL.' . PHP_EOL);
}

try {
    $pdo = new PDO('mysql:host=localhost;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    $pdo->exec($sqlContent);
    echo 'Import SQL berhasil. Semua data panduan sholat sudah dimasukkan.' . PHP_EOL;
} catch (PDOException $e) {
    echo 'Import SQL gagal: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}
