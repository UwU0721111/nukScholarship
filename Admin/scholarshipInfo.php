<?php
session_start();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>獎助學金資料管理</title>
</head>
<body>
    <?php
    require_once "../dbHandler.inc.php";
    $result=$conn->query("select * from 獎學金_條件 natural join 獎學金");
    ?>
    <form action="scholarshipInfoHandler.inc.php" method="POST">
    <table border="1">
        <tr>
            <th>名稱</th>
            <th>條件</th>
            <th>補助金額</th>
            <th>期限</th>
            <th>名額</th>
            <th>獎助單位帳號</th>
        </tr>
    <?php
    foreach($result as $row){
    ?>
        <tr>
        <td><?php echo htmlspecialchars($row['名稱']);?></td>
        <input type = "hidden" name = "name[]" value = "<?php echo htmlspecialchars($row['名稱']);?>">
        <td><input type="text" name="req[]" size="30" value="<?php echo htmlspecialchars($row['條件']);?>"></td>
        <td><input type="text" name="amount[]" size="5" value="<?php echo htmlspecialchars($row['補助金額']);?>"></td>
        <td><input type="text" name="deadline[]" size="7" value="<?php echo htmlspecialchars($row['期限']);?>"></td>
        <td><input type="text" name="quota[]" size="2" value="<?php echo htmlspecialchars($row['名額']);?>"></td>
        <td><?php echo htmlspecialchars($row['獎助單位帳號']);?></td>
        <input type = "hidden" name = "acc[]" value = "<?php echo htmlspecialchars($row['獎助單位帳號']);?>">
        </tr>  
        <?php 
    }
    ?>
    </table>
    <button name="button" value="cancel">取消</button>        
    <button name="button" value="submit">修改</button>
    </form>   
</body>
</html>