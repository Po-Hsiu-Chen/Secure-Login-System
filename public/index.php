<?php session_start(); ?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>首頁 - Web 應用系統</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="main-container">
        <h1>Web應用系統 首頁</h1>
        <div class="menu">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="login.php">登入</a>
                <a href="register.php">註冊</a>
            <?php else: ?>
                <a href="change_password.php">修改密碼</a>
                <a href="logout.php">登出</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
