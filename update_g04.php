<?php
$file = 'config/data.php';
$content = file_get_contents($file);

$lines = explode("\n", $content);
$current_kode = '';
foreach ($lines as $i => $line) {
    if (preg_match("/'kode'\s*=>\s*'([^']+)'/", $line, $matches)) {
        $current_kode = $matches[1];
    }
    
    if (strpos($line, "'video'") !== false && $current_kode === 'G04') {
        $url = 'https://www.youtube.com/embed/wZlEk4Rztfc?start=202&end=218';
        $lines[$i] = preg_replace("/'video'\s*=>\s*.*,/", "'video'    => '" . $url . "',", $line);
        break; // we only need to update G04
    }
}

file_put_contents($file, implode("\n", $lines));
echo "Updated video link for G04 successfully.\n";
