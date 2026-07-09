<?php
$file = 'config/data.php';
$content = file_get_contents($file);

// We need to replace 'https://www.youtube.com/embed/LH4Te_KiILY' with 'https://www.youtube.com/embed/lx-xTinCAlA?start=0&end=0'
// EXCEPT in the Surah Al Ikhlas section which is G04 / id => 4.
// To do this safely, we can break the file into parts or use regex.

$lines = explode("\n", $content);
$in_g04 = false;
$new_lines = [];

foreach ($lines as $line) {
    if (strpos($line, "'kode'       => 'G04'") !== false) {
        $in_g04 = true;
    }
    if (strpos($line, "'kode'       => 'G05'") !== false) {
        $in_g04 = false;
    }
    
    if (!$in_g04 && strpos($line, 'https://www.youtube.com/embed/LH4Te_KiILY') !== false) {
        $line = str_replace('https://www.youtube.com/embed/LH4Te_KiILY', 'https://www.youtube.com/embed/lx-xTinCAlA?start=[START]&end=[END]', $line);
    }
    $new_lines[] = $line;
}

file_put_contents($file, implode("\n", $new_lines));
echo "Updated video links successfully.\n";
