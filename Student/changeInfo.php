<?php
session_start();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>個人資料</title>
    <style>
        body {
            background-color: #f0f0f0; /* 淺灰色背景 */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center; /* 整體置中 */
        }
        .container {
            display: inline-block;
            background: #fff;
            padding: 30px 40px;
            margin-top: 60px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: left; /* 表單內容靠左 */
        }
        label {
            display: inline-block;
            width: 100px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input {
            padding: 6px;
            margin-bottom: 15px;
            width: 250px;
        }
        .buttons {
            text-align: center;
            margin-top: 20px;
        }
        button {
            padding: 8px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }
        button[value="cancel"] {
            background-color: #d9534f;
        }
        button[value="cancel"]:hover {
            background-color: #c9302c;
        }
        button[value="submit"] {
            background-color: #4CAF50;
        }
        button[value="submit"]:hover {
            background-color: #45a049;
        }
    </style>
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
    <div class="container">
        <h2 style="text-align:center; margin-bottom:20px;">個人資料</h2>
        <form action="changeInfoHandler.inc.php" method="POST">
            <label>姓名：</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name);?>"><br>
            
            <label>身分：</label>
            <span><?php echo htmlspecialchars($role);?></span><br>
            
            <label>學號：</label>
            <span><?php echo htmlspecialchars($username);?></span><br>
            
            <label>密碼：</label>
            <input type="text" name="pwd" value="<?php echo htmlspecialchars($pwd);?>"><br>
            
            <label>電話：</label>
            <input type="text" name="tel" value="<?php echo htmlspecialchars($tel);?>"><br>
            
            <label>email：</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email);?>"><br>
            
            <label>身分證ID：</label>
            <span><?php echo htmlspecialchars($ssn);?></span><br>
            
            <div class="buttons">
                <button name="button" value="cancel">取消</button>        
                <button name="button" value="submit">修改</button>
            </div>
        </form>   
    </div>
</body>
</html>
