<?php

session_start();

// 检查是否已登录
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: index.php");
    exit();
}

// 允许的文件类型

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file"])) {
    $uploadDir = ".././";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $file = $_FILES["file"];
    $filename = pathinfo($file["name"], PATHINFO_FILENAME);
    $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    // 生成安全文件名
    $safeFilename = preg_replace("/[^a-zA-Z0-9_\-]/", "", $filename) . "." . $extension;
    $filePath = $uploadDir . $safeFilename;

    // MIME 类型检查
    if (move_uploaded_file($file["tmp_name"], $filePath)) {
        // 获取文件修改日期
        $fileDate = (new DateTime())->setTimestamp(filemtime($filePath))->format("Y-m-d");

        // 更新 DATA.TXT 文件
        $dataContent = sprintf("%s,%s", $file["name"], $fileDate);
        file_put_contents("..\.\DATA.TXT", $dataContent);
        $success = "文件上传成功: " . htmlspecialchars($safeFilename);
    } else {
        $error = "文件上传失败！";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>上传文件</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
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
            margin-top: 20px;
        }
        input, button, select {
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
        .logout-btn {
            background-color: #f44336;
        }
        .logout-btn:hover {
            background-color: #d32f2f;
        }
        .settings {
            margin-top: 20px;
            width: 350px;
        }
    </style>
    <script>
  const localVersion = '1.4.110Beta'; // 当前版本号

  async function checkVersion() {
    try {
      const response = await fetch('http://47.103.192.39/version.json'); // 远程 JSON 文件地址
      const data = await response.json();
      const remoteVersion = data.version;
      const updateNotes = data.notes || '暂无更新说明'; // 获取更新内容

      if (remoteVersion !== localVersion) {
        // 显示提示框，包含版本号和更新内容
        alert(
          `检测到新版本：${remoteVersion}\n\n更新内容：\n${updateNotes}\n\n请尽快更新系统。`
        );
        // 如果你有UI界面，也可以用 Modal 或浮层展示更优美的提示
      } else {
        console.log('当前已是最新版本');
      }
    } catch (err) {
      console.error('版本检查失败：', err);
    }
  }

  window.addEventListener('load', checkVersion);
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

            // 将设置同步到表单值
            document.getElementById("theme-select").value = theme;
            document.getElementById("bg-image").value = bgImage;
            document.getElementById("bg-blur").value = parseInt(bgBlur);
        }

        // 保存设置
        function saveSettings() {
            const theme = document.getElementById("theme-select").value;
            const bgImage = document.getElementById("bg-image").value;
            const bgBlur = document.getElementById("bg-blur").value + "px";

            localStorage.setItem("theme", theme);
            localStorage.setItem("bgImage", bgImage);
            localStorage.setItem("bgBlur", bgBlur);

            loadSettings();
        }

        window.onload = loadSettings;
    </script>
</head>
<body>
    <div class="container">
        <h1>上传文件</h1>
        <?php if (!empty($success)) { echo "<p style='color:green;'>$success</p>"; } ?>
        <?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <button type="submit">上传</button>
        </form>
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">注销</button>
        </form>
        <h2>设置</h2>
        <label for="theme-select">主题:</label>
        <select id="theme-select">
            <option value="light">浅色模式</option>
            <option value="dark">深色模式</option>
        </select>
        <label for="bg-image">背景图片 URL:</label>
        <input type="text" id="bg-image" placeholder="输入图片链接">
        <label for="bg-blur">背景模糊度 (像素):</label>
        <input type="number" id="bg-blur" min="0" max="20" value="0">
        <button onclick="saveSettings()">应用设置</button>
    </div>
</body>
</html>
