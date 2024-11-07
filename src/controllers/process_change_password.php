<?php
define('BASE_URL', '/Secure-Login-System');
require_once(__DIR__ . '/../config/conn.php');
session_start();

$username = $_SESSION['username'];
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];

$sql = "SELECT * FROM account WHERE username='$username'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if (!password_verify($old_password, $row['password'])) {
    echo "<script>alert('舊密碼不正確'); window.location.href='/01157006_refactored/public/home.php';</script>";
    exit();
}

if (strlen($new_password) < 8 || !preg_match('/[A-Z]/', $new_password) || !preg_match('/[a-z]/', $new_password) || !preg_match('/[0-9]/', $new_password)) {
    echo "<script>alert('新密碼必須至少 8 個字元，包含大小寫字母和數字'); window.location.href='/01157006_refactored/public/home.php';</script>";
    exit();
}

if (password_verify($new_password, $row['password']) || password_verify($new_password, $row['password1']) || password_verify($new_password, $row['password2'])) {
    echo "<script>alert('新密碼不得與前三代密碼相同'); window.location.href='/01157006_refactored/public/home.php';</script>";
    exit();
}

// 更新密碼
$new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
$conn->query("UPDATE account SET password2 = password1, password1 = password, password = '$new_hashed_password' WHERE username='$username'");

echo "<script>alert('密碼修改成功'); window.location.href='/01157006_refactored/public/home.php';</script>";
?>
