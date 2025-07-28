<?php
if (file_exists('feedback.txt')) {
    $lines = array_reverse(file('feedback.txt')); // 倒序显示
    echo "<pre>";
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if (!empty($trimmed)) {
            echo "📝 " . htmlspecialchars($trimmed) . "\n\n";
        }
    }
    echo "</pre>";
} else {
    echo "<p>暂无反馈内容。</p>";
}
?>
