<?php
session_start();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生資料</title>
</head>
<body>
    <?php
    require_once "dbHandler.inc.php";
    $username=$_SESSION['username'];
    $result=$conn->query("select 使用者.姓名, 學號, 電話, email, 使用者.身分證ID, 監護人.姓名 as 監護人姓名, 關係 
    from (select 科系 from 老師 where 老師帳號='$username')as major, 使用者, 學生, 監護人 
    where 帳號=學生.學生帳號 and 學生.學生帳號=監護人.學生帳號 and 系所=major.科系 order by 學生.學生帳號 asc");
    ?>
    <table border="1">
        <tr>
            <th>姓名</th>
            <th>學號</th>
            <th>電話</th>
            <th>email</th>
            <th>身分證ID</th>
            <th>監護人姓名</th>
            <th>關係</th>
        </tr>
    <?php
    foreach($result as $row){
        echo "<tr>";
        echo "<td>";
        echo htmlspecialchars($row['姓名']);
        echo "</td>";
        echo "<td>";
        echo htmlspecialchars($row['學號']);
        echo "</td>";
        echo "<td>";
        echo htmlspecialchars($row['電話']);
        echo "</td>";
        echo "<td>";
        echo htmlspecialchars($row['email']);
        echo "</td>";
        echo "<td>";
        echo htmlspecialchars($row['身分證ID']);
        echo "</td>";
        echo "<td>";
        echo htmlspecialchars($row['監護人姓名']);
        echo "</td>";
        echo "<td>";
        echo htmlspecialchars($row['關係']);
        echo "</td>";
        echo "</tr>";   
    }
    ?>
    </table>
    <br>
    <button onclick="location.href='teacherPage.php'">回首頁</button>
</body>
</html>