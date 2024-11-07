<?php
define('BASE_URL', '/Secure-Login-System');
require_once(__DIR__ . '/../config/conn.php');
session_start();

$username = $_POST['username'];
$realname = $_POST['realname'];
$password = $_POST['password'];

// 檢查帳號是否已註冊
$sql = "SELECT * FROM account WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // 帳號已存在，顯示錯誤訊息並跳回註冊頁面
    echo "<script>alert('此帳號已經註冊過了，請使用其他帳號。'); window.location.href='/01157006_refactored/public/register.php';</script>";
    exit();
}

// 密碼檢查
if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
    echo "<script>alert('密碼必須至少 8 個字元，並包含大小寫字母和數字。'); window.location.href='/01157006_refactored/public/register.php';</script>";
    exit();
}

// 註冊新用戶
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO account (username, realname, password) VALUES (?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error); // 捕獲錯誤
}
$stmt->bind_param("sss", $username, $realname, $hashed_password);

if ($stmt->execute()) {
    echo "<script>alert('註冊成功！去登入'); window.location.href='/01157006_refactored/public/login.php';</script>";
} else {
    echo "<script>alert('註冊失敗，稍後再試'); window.location.href='/01157006_refactored/public/register.php';</script>";
}
?>
