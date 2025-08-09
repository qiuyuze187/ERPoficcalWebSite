<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
$feedbacks = file_exists('feedback.txt') ? file('feedback.txt', FILE_IGNORE_NEW_LINES) : [];
$replies = file_exists('replies.txt') ? file('replies.txt', FILE_IGNORE_NEW_LINES) : [];
$pinned = [];

foreach ($feedbacks as $line) {
    list($id, $user, $content, $timestamp, $is_pinned) = explode('|', $line);
    if ($is_pinned === '1') $pinned[] = $line;
}

function display_feedback($line, $replies) {
    list($id, $user, $content, $timestamp, $is_pinned) = explode('|', $line);
    echo "<div class='feedback-box'>";
    echo "<strong>{$user}</strong> <em>({$timestamp})</em><br><p>{$content}</p>";
    if ($_SESSION['is_admin']) {
        echo "<a class='admin-link' href='pin.php?id={$id}'>置顶</a><br>";
    }
    echo "<form method='post' action='reply.php'>
            <input type='hidden' name='id' value='{$id}'>
            <input type='text' name='reply' placeholder='回复内容' required>
            <button type='submit'>提交回复</button>
          </form>";
    foreach ($replies as $r) {
        list($fid, $ruser, $rcontent, $rtimestamp) = explode('|', $r);
        if ($fid === $id) {
            echo "<div class='reply-box'><strong>{$ruser}</strong> 回复：{$rcontent} <em>({$rtimestamp})</em></div>";
        }
    }
    echo "</div>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>反馈系统</title>
    <?php include 'style.php'; ?>
</head>
<body>
<div class="container">
    <h2>欢迎，<?= $_SESSION['user'] ?></h2>
    <a href="logout.php">注销</a> | <a href="submit.php">提交反馈</a><br><br>
    <?php
    foreach ($pinned as $line) display_feedback($line, $replies);
    foreach ($feedbacks as $line) {
        if (!in_array($line, $pinned)) display_feedback($line, $replies);
    }
    ?>
</div>
</body>
</html>
