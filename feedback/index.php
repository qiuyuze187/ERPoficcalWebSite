<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $users = file('users.txt', FILE_IGNORE_NEW_LINES);

    foreach ($users as $user) {
        list($u, $p) = explode('|', $user);
        if ($u === $username && $p === $password) {
            $_SESSION['user'] = $username;
            $_SESSION['is_admin'] = ($username === 'admin');
            header('Location: dashboard.php');
            exit;
        }
    }
    $error = "登录失败";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>登录</title>
    <?php include 'style.php'; ?>
</head>
<body>
<div class="container">
    <h2>用户登录</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        用户名：<input type="text" name="username" required><br>
        密码：<input type="password" name="password" required><br>
        <button type="submit">登录</button>
        <p>没有账号？<a href="register.php">点击注册</a></p>
    </form>
</div>
</body>
</html>
