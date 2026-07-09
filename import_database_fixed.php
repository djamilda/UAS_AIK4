<?php
// import_database_fixed.php — Import SQL seed file into MySQL using PDO with robust statement parsing.

$sqlFile = __DIR__ . '/config/database.sql';
if (!file_exists($sqlFile)) {
    die('File SQL tidak ditemukan: ' . $sqlFile . PHP_EOL);
}

$sqlContent = file_get_contents($sqlFile);
if ($sqlContent === false) {
    die('Gagal membaca file SQL.' . PHP_EOL);
}

// Remove Windows line ending issues then split by semicolon followed by a newline.
$sqlContent = str_replace(["\r\n", "\r"], "\n", $sqlContent);
$statements = preg_split('/;\n+/', $sqlContent);

try {
    $dsn = 'mysql:host=localhost;charset=utf8mb4';
    $pdo = new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    $executed = 0;
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if ($statement === '') {
            continue;
        }

        // Skip a full-line SQL comment if the statement begins with it
        if (preg_match('/^--/', $statement)) {
            continue;
        }

        // Add the semicolon back for execution.
        $stmt = $statement . ';';
        $pdo->exec($stmt);
        $executed++;
    }

    echo "Import SQL berhasil. Statements executed: $executed" . PHP_EOL;
} catch (PDOException $e) {
    echo 'Import SQL gagal: ' . $e->getMessage() . PHP_EOL;
    exit(1);
}
