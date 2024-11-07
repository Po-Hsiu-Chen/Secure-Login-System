<?php
// 讀取專案根目錄的 .env 檔案
$env = parse_ini_file(__DIR__ . '/../../.env');

$servername = $env['DB_HOST'];
$username   = $env['DB_USERNAME'];
$password   = $env['DB_PASSWORD'];
$dbname     = $env['DB_DATABASE'];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("資料庫連線失敗：" . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
