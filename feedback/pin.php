<?php
session_start();
if (!$_SESSION['is_admin']) exit;

$id = $_GET['id'];
$lines = file('feedback.txt', FILE_IGNORE_NEW_LINES);
$new_lines = [];

foreach ($lines as $line) {
    list($fid, $user, $content, $timestamp, $is_pinned) = explode('|', $line);
    $new_lines[] = ($fid === $id)
        ? "{$fid}|{$user}|{$content}|{$timestamp}|1"
        : $line;
}
file_put_contents('feedback.txt', implode("\n", $new_lines));
header('Location: dashboard.php');
