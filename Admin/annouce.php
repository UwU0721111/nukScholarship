<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>公告管理</title>
</head>
<body>
    <h3>公告</h3><br>
    <?php
    require_once "../dbHandler.inc.php";
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
    <h3>發布新公告</h3><br>
    <form action="annonHandler.inc.php" method="POST">
        <label>內容：</label><br>
        <textarea type="text" name="content" cols="50" rows="5"></textarea><br>
        <button name="button" value="cancel">取消</button>        
        <button name="button" value="submit">送出</button>
    </form>
</body>
</html>