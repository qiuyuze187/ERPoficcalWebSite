<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);
    $captcha = strtoupper(trim($_POST['captcha']));
    $valid = strtoupper($_SESSION['captcha'] ?? '');

    if (empty($username) || empty($password) || empty($confirm) || empty($captcha)) {
        $error = "所有字段均为必填";
    } elseif ($password !== $confirm) {
        $error = "两次密码不一致";
    } elseif ($captcha !== $valid) {
        $error = "验证码错误";
    } else {
        $users = file_exists('users.txt') ? file('users.txt', FILE_IGNORE_NEW_LINES) : [];
        foreach ($users as $user) {
            list($u, ) = explode('|', $user);
            if ($u === $username) {
                $error = "用户名已存在";
                break;
            }
        }

        if (!isset($error)) {
            file_put_contents('users.txt', "{$username}|{$password}\n", FILE_APPEND);
            $_SESSION['user'] = $username;
            $_SESSION['is_admin'] = ($username === 'admin');
            header('Location: dashboard.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>注册</title>
    <?php include 'style.php'; ?>
</head>
<body>
<div class="container">
    <h2>用户注册</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        用户名：<input type="text" name="username" required><br>
        密码：<input type="password" name="password" required><br>
        确认密码：<input type="password" name="confirm" required><br>
        验证码：<input type="text" name="captcha" required><br>
        <img src="captcha.php" alt="验证码" onclick="this.src='captcha.php?'+Math.random()" style="cursor:pointer;"><br>
        <button type="submit">注册</button>
    </form>
    <p>已有账号？<a href="index.php">点击登录</a></p>
</div>
</body>
</html>
