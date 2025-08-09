<?php
session_start();

// 生成验证码字符串
$code = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 5);
$_SESSION['captcha'] = $code;

// 创建图像
$width = 120;
$height = 40;
$image = imagecreatetruecolor($width, $height);

// 设置颜色
$bgColor = imagecolorallocate($image, 255, 255, 255); // 白色背景
$textColor = imagecolorallocate($image, 0, 0, 0);     // 黑色文字
$lineColor = imagecolorallocate($image, 200, 200, 200); // 灰色干扰线

// 填充背景
imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);

// 添加干扰线
for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0, $width), rand(0, $height),
              rand(0, $width), rand(0, $height), $lineColor);
}

// 使用默认字体绘制验证码
$font = 5; // GD 默认字体大小（1~5）
$textWidth = imagefontwidth($font) * strlen($code);
$textHeight = imagefontheight($font);
$x = ($width - $textWidth) / 2;
$y = ($height - $textHeight) / 2;
imagestring($image, $font, $x, $y, $code, $textColor);

// 输出图像
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
