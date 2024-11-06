<?php
session_start();

// 處理登出功能
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // 清除所有 Session 資料
    session_unset();
    session_destroy();

    // 跳回登入頁面
    header("Location: login.php");
    exit();
}

// 確認用戶是否已登入
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // 未登入則跳回登入頁面
    exit();
}

// 取得用戶姓名
$realname = $_SESSION['realname'] ?? '訪客'; 
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>主頁</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="main-header">
        <header>
            <h1>歡迎 <?php echo htmlspecialchars($realname, ENT_QUOTES, 'UTF-8'); ?>！</h1>
        </header><br>
        
        <!-- 登出 -->
        <form method="post">
            <button type="submit" name="logout" class="btn">登出</button>
        </form><br>

        <section class="container">
            <!-- 修改密碼表單 -->
            <h2>修改密碼</h2>
            <form action="../src/controllers/process_change_password.php" method="post" class="change-password-form">
                <label for="old_password">舊密碼:</label>
                <input type="password" id="old_password" name="old_password" required>
                <label for="new_password">新密碼:</label>
                <input type="password" id="new_password" name="new_password" required>
                <button type="submit" class="btn">修改密碼</button>
            </form>
        </section>
    </div>
</body>
</html>
