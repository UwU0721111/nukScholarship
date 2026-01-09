<?php
session_start();
?> 
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生資料</title>
    <style>
        body {
            background-color: #f0f0f0; /* 1. 淺灰色背景 */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center; /* 2. 標題置中 */
            margin-top: 24px;
            margin-bottom: 16px;
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto; /* 2. 表格置中 */
        }
        th, td {
            border: 1px solid #666;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        .back-btn {
            position: fixed;   /* 3. 固定右下角 */
            right: 20px;
            bottom: 20px;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background-color: #4a4a4a;
            color: #fff;
            cursor: pointer;
        }
        .back-btn:hover {
            background-color: #3a3a3a;
        }
    </style>
</head>
<body>
    <h2>學生資料</h2>
    <?php
    require_once "../dbHandler.inc.php";
    $username=$_SESSION['username'];
    $result=$conn->query("select 使用者.姓名, 學號, 電話, email, 使用者.身分證ID, 監護人.姓名 as 監護人姓名, 關係 
    from (select 科系 from 老師 where 老師帳號='$username')as major, 使用者, 學生, 監護人 
    where 帳號=學生.學生帳號 and 學生.學生帳號=監護人.學生帳號 and 系所=major.科系 order by 學生.學生帳號 asc");
    ?>
    <table>
        <tr>
            <th>學號</th>
            <th>姓名</th>
            <th>電話</th>
            <th>email</th>
            <th>身分證ID</th>
            <th>監護人姓名</th>
            <th>關係</th>
        </tr>
    <?php
    foreach($result as $row){
        echo "<tr>";
        echo "<td>".htmlspecialchars($row['學號'])."</td>";
        echo "<td>".htmlspecialchars($row['姓名'])."</td>";
        echo "<td>".htmlspecialchars($row['電話'])."</td>";
        echo "<td>".htmlspecialchars($row['email'])."</td>";
        echo "<td>".htmlspecialchars($row['身分證ID'])."</td>";
        echo "<td>".htmlspecialchars($row['監護人姓名'])."</td>";
        echo "<td>".htmlspecialchars($row['關係'])."</td>";
        echo "</tr>";   
    }
    ?>
    </table>

    <button class="back-btn" onclick="location.href='teacherPage.php'">回首頁</button>
</body>
</html>
