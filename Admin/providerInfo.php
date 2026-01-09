<?php
session_start();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>獎助單位資料管理</title>
</head>
<body>
    <?php
    require_once "../dbHandler.inc.php";
    $result=$conn->query("select * from 獎助單位, 使用者 where 帳號=獎助單位帳號");
    ?>
    <form action="providerInfoHandler.inc.php" method="POST">
    <table border="1">
        <tr>
            <th>帳號</th>
            <th>名稱</th>
            <th>聯絡人</th>       
            <th>密碼</th>
            <th>電話</th>
            <th>Email</th>
            <th>身分證ID</th>
        </tr>
    <?php
    foreach($result as $row){
    ?>
        <tr>
        <td><?php echo htmlspecialchars($row['帳號']);?></td>
        <input type = "hidden" name = "acc[]" value = "<?php echo htmlspecialchars($row['帳號']);?>">
        <td><input type="text" name="name[]" size="15" value="<?php echo htmlspecialchars($row['姓名']);?>"></td>
        <td><input type="text" name="contact[]" size="13" value="<?php echo htmlspecialchars($row['聯絡人']);?>"></td>
        <td><input type="text" name="pwd[]" size="10" value="<?php echo htmlspecialchars($row['密碼']);?>"></td>
        <td><input type="text" name="tel[]" size="10" value="<?php echo htmlspecialchars($row['電話']);?>"></td>
        <td><input type="text" name="email[]" size="25" value="<?php echo htmlspecialchars($row['email']);?>"></td>
        <td><input type="text" name="ssn[]" size="10" value="<?php echo htmlspecialchars($row['身分證ID']);?>"></td>
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