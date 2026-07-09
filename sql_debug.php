<?php
$sql = file_get_contents(__DIR__ . '/config/database.sql');
if ($sql === false) {
    echo "FAILED\n";
    exit(1);
}
echo "LEN=" . strlen($sql) . "\n";
$pos = strpos($sql, 'INSERT INTO `bacaan_sholat`');
echo "POS=" . ($pos === false ? 'false' : $pos) . "\n";
$sub = substr($sql, $pos ?: 0, 200);
echo "SUB=<<<\n" . $sub . "\n>>>\n";
