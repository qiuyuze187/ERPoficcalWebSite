<?php

session_start();

// 清空所有会话数据
session_unset();

// 销毁会话
session_destroy();

// 重新生成会话 ID，防止会话固定攻击
session_regenerate_id(true);

// 重定向到登录页面
header("Location: index.php");
exit();
?>
