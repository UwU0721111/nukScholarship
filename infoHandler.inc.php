<?php
session_start();
?> 
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name=$_POST['name'];
    $pwd=$_POST['pwd'];
    $tel=$_POST['tel'];
    $email=$_POST['email'];

    require_once "dbHandler.inc.php";
    $username=$_SESSION['username'];
    $result=$conn->query("update 使用者 set 姓名='$name', 密碼='$pwd',
                          電話='$tel', email='$email' where 帳號='$username'");
    if($result){
        $_SESSION['name']=$name;
        echo"修改成功";
        ?>
        <br>
        <button onclick="location.href='studentPage.php'">回首頁</button>
        <?php
    }
}