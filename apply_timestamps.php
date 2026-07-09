<?php
$file = 'config/data.php';
$content = file_get_contents($file);

$replacements = [
    'G01' => 'https://www.youtube.com/embed/lx-xTinCAlA?start=5&end=28',
    'G02' => 'https://www.youtube.com/embed/lx-xTinCAlA?start=28&end=84',
    'G03' => 'https://www.youtube.com/embed/lx-xTinCAlA?start=91&end=125',
    'G04' => 'https://www.youtube.com/embed/lx-xTinCAlA?start=128&end=178',
    'G05' => 'https://www.youtube.com/embed/lx-xTinCAlA?start=178&end=193',
    'G06' => 'https://www.youtube.com/embed/lx-xTinCAlA?start=193&end=209',
    'G07' => 'https://www.youtube.com/embed/lx-xTinCAlA?start=209&end=275',
    'G08' => 'https://www.youtube.com/embed/lx-xTinCAlA?start=275&end=282',
    'G09' => 'https://www.youtube.com/embed/lx-xTinCAlA?start=282&end=290',
    'G10' => 'https://www.youtube.com/embed/lx-xTinCAlA?start=529&end=568',
    'G11' => 'https://www.youtube.com/embed/lx-xTinCAlA?start=568'
];

$lines = explode("\n", $content);
$current_kode = '';
foreach ($lines as $i => $line) {
    if (preg_match("/'kode'\s*=>\s*'([^']+)'/", $line, $matches)) {
        $current_kode = $matches[1];
    }
    
    if (strpos($line, "'video'") !== false) {
        if (isset($replacements[$current_kode])) {
            $url = $replacements[$current_kode];
            $lines[$i] = preg_replace("/'video'\s*=>\s*.*,/", "'video'    => '" . $url . "',", $line);
        }
    }
}

file_put_contents($file, implode("\n", $lines));
echo "Updated video links successfully.\n";
