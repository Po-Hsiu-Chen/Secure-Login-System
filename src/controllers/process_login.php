<?php
define('BASE_URL', '/Secure-Login-System');
require_once(__DIR__ . '/../config/conn.php');
session_start();

// 獲取外部公共 IP 的函數
function getUserIP() {
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_array = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ip_array[0]);
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // 驗證 IP 是否有效
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        return $ip;
    }
    return '未知 IP'; 
}


$username = $_POST['username'];
$password = $_POST['password'];
$ip_address = getUserIP(); // 獲取外部公共 IP

// 先檢查是否在鎖定中
$sql = "SELECT * FROM rec_login 
        WHERE username = ? 
        AND TIMEDIFF(NOW(), login_time) < '00:05:00' 
        AND locked = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('帳號已鎖定，5分鐘後再試'); window.location.href='/01157006_refactored/public/login.php';</script>";
    exit();
}

// 查詢用戶
$stmt = $conn->prepare("SELECT * FROM account WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user_result = $stmt->get_result();

// 確實有此帳號
if ($user_result->num_rows > 0) {
    $row = $user_result->fetch_assoc();

    // 驗證密碼，成功登入
    if (password_verify($password, $row['password'])) {
        echo "Debug: Realname from DB: " . $row['realname']; 
        $_SESSION['username'] = $username;
        $_SESSION['realname'] = $row['realname'];
        
        // 記錄登入資訊
        $stmt = $conn->prepare("INSERT INTO rec_login (username, login_time, result, locked, ip_address) VALUES (?, NOW(), 1, 0, ?)");
        $stmt->bind_param("ss", $username, $ip_address);
        $stmt->execute();
        header("Location: /01157006_refactored/public/home.php");
        exit();
    }
}

// 處理登入失敗
$sql = "SELECT COUNT(*) FROM rec_login 
        WHERE username = ? 
        AND TIMEDIFF(NOW(), login_time) <= '00:05:00' 
        AND result = 0"; // 查找5分鐘內失敗的記錄
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_row();
$fail_count = $row[0];

// 判斷是否需要鎖定
if ($fail_count >= 2) {
    $lock = 1; // 鎖定帳號
} else {
    $lock = 0; // 不鎖定
}

// 記錄失敗登入資訊
$stmt = $conn->prepare("INSERT INTO rec_login (username, login_time, result, locked, ip_address) VALUES (?, NOW(), 0, ?, ?)");
$stmt->bind_param("sis", $username, $lock, $ip_address);
$stmt->execute();
echo "<script>alert('帳號或密碼錯誤'); window.location.href='/01157006_refactored/public/login.php';</script>";
?>
