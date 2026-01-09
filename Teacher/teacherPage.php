<?php
session_start();
?> 
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>老師頁面</title>
    <style>
        body {
            background-color: #f0f0f0; /* 淺灰色背景 */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center; /* 標題置中 */
        }
        h4 {
            margin-top: 30px;
            font-size: 22px;
            color: #333;
        }
        .btn {
            display: inline-block;
            margin: 10px 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .logout-btn {
            position: fixed;   /* 固定右下角 */
            right: 20px;
            bottom: 20px;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background-color: #d9534f;
            color: #fff;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <h4><?php echo htmlspecialchars($_SESSION['name']); ?> 老師 </h4><br>

    <!-- 改成按鈕樣式 -->
    <a href="studentInfo.php" class="btn">學生資料</a>
    <a href="recommendation.php" class="btn">寫推薦信</a><br><br>

    <button class="logout-btn" onclick="location.href='../logout.inc.php'">登出</button>
</body>
</html>
