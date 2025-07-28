<?php
session_start();

// 直接使用字符串对比，而不是 `password_verify()`
define("USERNAME", "admin");
define("PASSWORD", "20241111qjc,.");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';

    if ($username === USERNAME && $password === PASSWORD) {
        $_SESSION["authenticated"] = true;
        header("Location: upload.php");
        exit();
    } else {
        $error = "用户名或密码错误！";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>登录</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: var(--bg-color, #f9f9f9);
            background-image: var(--bg-image, none);
            background-size: cover;
            background-position: center;
            backdrop-filter: blur(var(--bg-blur, 0px));
            color: var(--text-color, #333);
        }
        .container {
            width: 350px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: var(--card-color, #fff);
        }
        input, button {
            display: block;
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        button:active {
            background-color: #3e8e41;
            box-shadow: inset 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .settings {
            margin-top: 20px;
            width: 350px;
        }
    </style>
    <script>
        // 加载设置
        function loadSettings() {
            const theme = localStorage.getItem("theme") || "light";
            const bgImage = localStorage.getItem("bgImage") || "none";
            const bgBlur = localStorage.getItem("bgBlur") || "0px";

            document.body.classList.toggle("dark-mode", theme === "dark");
            document.body.style.setProperty("--bg-color", theme === "dark" ? "#121212" : "#f9f9f9");
            document.body.style.setProperty("--text-color", theme === "dark" ? "#ffffff" : "#333");
            document.body.style.setProperty("--card-color", theme === "dark" ? "#1e1e1e" : "#fff");
            document.body.style.setProperty("--bg-image", bgImage !== "none" ? `url(${bgImage})` : "none");
            document.body.style.setProperty("--bg-blur", bgBlur);
        }

        window.onload = loadSettings;
    </script>
</head>
<body>
    <div class="container">
        <h1>登录</h1>
        <?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <form method="post">
            <label>用户名:</label>
            <input type="text" name="username" required>
            <label>密码:</label>
            <input type="password" name="password" required>
            <button type="submit">登录</button>
        </form>
    </div>
</body>
</html>

