<?php
session_start();
if (!isset($_SESSION['user'])) exit;

$id = $_POST['id'];
$reply = trim($_POST['reply']);
$user = $_SESSION['user'];
$timestamp = date('Y-m-d H:i:s');
$line = "{$id}|{$user}|{$reply}|{$timestamp}\n";
file_put_contents('replies.txt', $line, FILE_APPEND);
header('Location: dashboard.php');
