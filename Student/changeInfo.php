<?php
session_start();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>個人資料</title>
</head>
<body>
    <?php
    $username=$_SESSION['username'];
    require_once "../dbHandler.inc.php";
    $result=$conn->query("select * from 使用者 where 帳號='$username'");
    $user=$result->fetch_assoc();
    $name=$user['姓名'];
    $role=$user['種類'];
    $pwd=$user['密碼'];
    $tel=$user['電話'];
    $email=$user['email'];
    $ssn=$user['身分證ID'];
    ?>
    <form action="changeInfoHandler.inc.php" method="POST">
        <label>姓名：</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name);?>"><br>
        <label>身分：</label>
        <label><?php echo htmlspecialchars($role);?></label><br>
        <label>學號：</label>
        <label><?php echo htmlspecialchars($username);?></label><br>
        <label>密碼：</label>
        <input type="text" name="pwd" value="<?php echo htmlspecialchars($pwd);?>"><br>
        <label>電話：</label>
        <input type="text" name="tel" value="<?php echo htmlspecialchars($tel);?>"><br>
        <label>email：</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email);?>"><br>
        <label>身分證ID：</label>
        <label><?php echo htmlspecialchars($ssn);?></label><br>
        <button name="button" value="cancel">取消</button>        
        <button name="button" value="submit">修改</button>
    </form>   
</body>
</html>