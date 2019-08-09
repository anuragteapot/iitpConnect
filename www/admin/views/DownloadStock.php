<?php

$app = new Factory;
$mysql = $app->getDBO();
$sql = "SELECT * from stock";
$result = $mysql->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    array_push($data, $row);
}

function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// file name for download
$fileName = "Stock" . date('Ymd') . ".xls";

// headers for download
header("Content-Disposition: attachment; filename=\"$fileName\"");
header("Content-Type: application/vnd.ms-excel");

$flag = false;
foreach ($data as $row) {
    if (!$flag) {
        // display column names as first row
        echo implode("\t", array_keys($row)) . "\n";
        $flag = true;
    }
    // filter data
    array_walk($row, 'filterData');
    echo implode("\t", array_values($row)) . "\n";
}

exit;
