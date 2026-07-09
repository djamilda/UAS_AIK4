<?php
require_once 'config/data.php';

header('Content-Type: text/plain; charset=utf-8');

echo "Debug Data\n";
echo "========\n";
echo "DB available: " . (isDatabaseAvailable() ? 'yes' : 'no') . "\n";
echo "Gerakan count: " . (is_array($gerakanSholat) ? count($gerakanSholat) : 'unknown') . "\n";
if (is_array($gerakanSholat)) {
    foreach ($gerakanSholat as $idx => $gerakan) {
        echo sprintf("%02d: %s (%s)\n", $idx + 1, $gerakan['nama'] ?? 'N/A', $gerakan['kode'] ?? 'N/A');
    }
}
