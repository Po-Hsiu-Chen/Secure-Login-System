<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊頁面</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>註冊</h1>
        <form action="../src/controllers/process_register.php" method="post">
            <label for="username">帳號:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">密碼:</label>
            <input type="password" id="password" name="password" required>

            <label for="realname">姓名:</label>
            <input type="text" id="realname" name="realname" required>

            <button type="submit">註冊</button>
        </form>

        <div class="footer">
            <a href="login.php">已有帳號？ 去登入</a>
        </div>
    </div>
</body>
</html>
