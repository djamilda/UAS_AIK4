<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=panduan_sholat;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "Gerakan: " . $db->query('SELECT COUNT(*) FROM gerakan_sholat')->fetchColumn() . "\n";
    echo "Bacaan: " . $db->query('SELECT COUNT(*) FROM bacaan_sholat')->fetchColumn() . "\n";
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}
