<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

$ax = $_POST['ax'] ?? null;
$ay = $_POST['ay'] ?? null;
$az = $_POST['az'] ?? null;
$gx = $_POST['gx'] ?? null;
$gy = $_POST['gy'] ?? null;
$gz = $_POST['gz'] ?? null;
$magnitude = $_POST['magnitude'] ?? null;

if ($ax === null || $ay === null || $az === null || $gx === null || $gy === null || $gz === null) {
    echo "Data incomplete"; 
    exit();
}

$timestamp = date('Y-m-d H:i:s');
$command = escapeshellcmd("python predict.py $gx $gy $gz $magnitude");
$output = shell_exec($command);

if ($output === null) {
    echo "Lỗi khi chạy lệnh Python"; 
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "demoiot");

if ($mysqli->connect_errno) {
    echo "Lỗi kết nối: " . $mysqli->connect_error;
    exit();
}

$stmt = $mysqli->prepare("INSERT INTO demoiot (timestamp, output) VALUES (?, ?)");
$stmt->bind_param("ss", $timestamp, $output);

if ($stmt->execute()) {
    echo "Dữ liệu đã được lưu vào cơ sở dữ liệu.";
} else {
    echo "Lỗi khi lưu dữ liệu: " . $stmt->error;
}

$stmt->close();
$mysqli->close();