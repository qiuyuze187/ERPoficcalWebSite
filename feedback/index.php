<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>用户反馈中心</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="feedback-container">
    <h1>用户反馈中心</h1>
    <form action="submit.php" method="post">
      <textarea name="message" rows="5" placeholder="欢迎留言，我们会认真阅读您的建议与问题" required></textarea>
      <button type="submit">提交反馈</button>
    </form>
    <div class="feedback-list">
      <h2>历史反馈</h2>
      <?php include 'view.php'; ?>
    </div>
  </div>
</body>
</html>
