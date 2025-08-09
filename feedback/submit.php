<?php
session_start();
if (!isset($_SESSION['user'])) exit;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content']);
    $id = uniqid();
    $user = $_SESSION['user'];
    $timestamp = date('Y-m-d H:i:s');
    $line = "{$id}|{$user}|{$content}|{$timestamp}|0\n";
    file_put_contents('feedback.txt', $line, FILE_APPEND);
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>提交反馈</title>
    <?php include 'style.php'; ?>
</head>
<body>
<div class="container">
    <h2>提交反馈</h2>
    <form method="post">
        <textarea name="content" placeholder="请输入反馈内容" required></textarea><br>
        <button type="submit">提交</button>
    </form>
</div>
</body>
</html>
