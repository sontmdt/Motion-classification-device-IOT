<?php
$ax = $_POST['ax'] ?? null;
$ay = $_POST['ay'] ?? null;
$az = $_POST['az'] ?? null;
$gx = $_POST['gx'] ?? null;
$gy = $_POST['gy'] ?? null;
$gz = $_POST['gz'] ?? null;
$magnitude = $_POST['magnitude'] ?? null;

if ($ax !== null && $ay !== null && $az !== null && $gx !== null && $gy !== null && $gz !== null && $magnitude !== null) {
    $timestamp = date('Y-m-d H:i:s');
    $data = "$timestamp $ax $ay $az $gx $gy $gz $magnitude" . PHP_EOL;
    file_put_contents('data.txt', $data, FILE_APPEND | LOCK_EX);
    echo "Data processed";
} else {
    echo "Data incomplete";
}
