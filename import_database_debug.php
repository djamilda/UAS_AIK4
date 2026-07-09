<?php
$sqlFile = __DIR__ . '/config/database.sql';
$sqlContent = file_get_contents($sqlFile);
$statements = preg_split('/;\s*(?:\r\n|\n|\r)/', $sqlContent);
$index = 0;
foreach ($statements as $statement) {
    $statement = trim($statement);
    if ($statement === '' || strpos($statement, '--') === 0) {
        continue;
    }
    $index++;
    echo "Statement $index: " . substr($statement, 0, 80) . "...\n";
}
echo "Total statements: $index\n";
