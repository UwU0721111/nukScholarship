<?php
session_start();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生頁面</title>
</head>
<body>
    <h4><?php echo htmlspecialchars($_SESSION['name']);?>學生 您好！</h4><br>
    <a href="info.php">修改個人資料</a>
    &nbsp;&nbsp;
    <a href="apply.php">申請獎學金</a><br>
    <h3>公告<h3><br>
    <?php
    require_once "dbHandler.inc.php";
    $result=$conn->query("select 日期, 內容 from 公告 order by 公告編號 desc");
    ?>
    <table border="1">
        <tr>
            <th>日期</th>
            <th>內容</th>
        </tr>
    <?php
    foreach($result as $row){
        echo "<tr>";
        echo "<td>";
        echo htmlspecialchars($row['日期']);
        echo "</td>";
        echo "<td>";
        echo htmlspecialchars($row['內容']); 
        echo "</td>";  
        echo "</tr>";     
    }
    ?>
    </table><br>
    <button onclick="location.href='logout.inc.php'">登出</button>
</body>
</html>