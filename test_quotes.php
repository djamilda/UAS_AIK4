<?php
require 'config/data.php';
$d = getStaticData();
$arab = $d[9]['bacaan'][0]['arab'];
echo "First 50 chars: " . substr($arab, 0, 50) . PHP_EOL;
echo "Has literal backslash-n: " . (strpos($arab, '\\n') !== false ? 'YES' : 'NO') . PHP_EOL;
echo "Has actual newline: " . (strpos($arab, "\n") !== false ? 'YES' : 'NO') . PHP_EOL;
echo "Length: " . strlen($arab) . PHP_EOL;

$salam = $d[10]['bacaan'][0]['arab'];
echo PHP_EOL . "Salam arab:" . PHP_EOL;
echo "Has literal backslash-n: " . (strpos($salam, '\\n') !== false ? 'YES' : 'NO') . PHP_EOL;
echo "Has actual newline: " . (strpos($salam, "\n") !== false ? 'YES' : 'NO') . PHP_EOL;
