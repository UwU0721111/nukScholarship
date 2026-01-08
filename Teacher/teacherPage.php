<?php
session_start();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>老師頁面</title>
</head>
<body>
    <h4><?php echo htmlspecialchars($_SESSION['name']);?>老師 您好！</h4><br>
    <a href="studentInfo.php">學生資料</a>
    &nbsp;&nbsp;
    <a href="recommendation.php">寫推薦信</a><br>
    <br>
    <button onclick="location.href='../logout.inc.php'">登出</button>
</body>
</html>