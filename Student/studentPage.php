<?php
session_start();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生頁面</title>
    <style>
        body {
            background-color: #f0f0f0; /* 淺灰色背景 */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center; /* 內容置中 */
        }
        h4 {
            margin-top: 30px;
            font-size: 22px;
            color: #333;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 70%;
        }
        th, td {
            border: 1px solid #666;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        button {
            margin: 10px;
            padding: 8px 20px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .logout {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #d9534f;
        }
        .logout:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <!-- 最上方顯示姓名 -->
    <h4><?php echo htmlspecialchars($_SESSION['name']); ?> 學生</h4><br>

    <!-- 功能按鈕區 -->
    <button onclick="location.href='changeInfo.php'">修改個人資料</button>
    <button onclick="location.href='../apply/applypage2.php'">申請獎學金</button>
    <button onclick="location.href='../apply/applypage.php'">查看申請資料</button>
    <button onclick="location.href='../apply/transcript.php'">查看成績單</button>

    <h3>公告</h3><br>
    <?php
    require_once "../dbHandler.inc.php";
    $result=$conn->query("select 日期, 內容 from 公告 order by 公告編號 desc");
    ?>
    <table>
        <tr>
            <th>日期</th>
            <th>內容</th>
        </tr>
    <?php
    foreach($result as $row){
        echo "<tr>";
        echo "<td>".htmlspecialchars($row['日期'])."</td>";
        echo "<td>".htmlspecialchars($row['內容'])."</td>";  
        echo "</tr>";     
    }
    ?>
    </table><br>

    <button class="logout" onclick="location.href='../logout.inc.php'">登出</button>
</body>
</html>
