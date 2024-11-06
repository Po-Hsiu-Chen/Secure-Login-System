<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入頁面</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>登入</h1>
        <form action="../src/controllers/process_login.php" method="post">
            <label for="username">帳號:</label>
            <input type="text" id="username" name="username" placeholder="請輸入帳號" required>
            
            <label for="password">密碼:</label>
            <input type="password" id="password" name="password" placeholder="請輸入密碼" required>
            
            <button type="submit">登入</button>
        </form>

        <div class="footer">
            <a href="register.php">沒有帳號？ 去註冊</a>
        </div>
    </div>
</body>
</html>
