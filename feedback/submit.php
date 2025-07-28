<?php
$message = trim($_POST['message']);
if (!empty($message)) {
    $entry = date('Y-m-d H:i:s') . " - " . $message . "\n";
    file_put_contents('feedback.txt', $entry, FILE_APPEND | LOCK_EX);
    echo "<script>alert('反馈已提交');window.location.href='index.php';</script>";
} else {
    echo "<script>alert('请填写反馈内容');window.location.href='index.php';</script>";
}
?>
