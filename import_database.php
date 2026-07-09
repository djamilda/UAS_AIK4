<?php
// import_database.php — Import SQL seed file ke database MySQL langsung dari PHP

$sqlFile = __DIR__ . '/config/database.sql';
if (!file_exists($sqlFile)) {
    die('File SQL tidak ditemukan: ' . $sqlFile . PHP_EOL);
}

$sqlContent = file_get_contents($sqlFile);
if ($sqlContent === false) {
    die('Gagal membaca file SQL.' . PHP_EOL);
}

try {
    $dsn = 'mysql:host=localhost;charset=utf8mb4';
    $pdo = new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    $statements = preg_split('/;\s*(?:\r\n|\n|\r)/', $sqlContent);
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if ($statement === '' || strpos($statement, '--') === 0) {
            continue;
        }
        $pdo->exec($statement);
    }

    echo 'Import SQL berhasil.' . PHP_EOL;
} catch (PDOException $e) {
    echo 'Import SQL gagal: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}
