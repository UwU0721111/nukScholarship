<?php
session_start();
?> 
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if($_POST['button']=="cancel"){
        header("Location: adminPage.php");
        exit();
    }
    $acc=$_POST['acc'];       
    $name=$_POST['name'];
    $contact=$_POST['contact'];
    $pwd=$_POST['pwd'];
    $tel=$_POST['tel'];
    $email=$_POST['email'];
    $ssn=$_POST['ssn'];
    $count=count($acc);
    require_once "../dbHandler.inc.php";
    for($i=0;$i<$count;$i++)
    {
        $ac=$acc[$i];       
        $na=$name[$i];
        $con=$contact[$i];
        $pass=$pwd[$i];
        $te=$tel[$i];
        $mail=$email[$i];
        $ss=$ssn[$i];
        $conn->query("update 使用者 set 姓名='$na', 密碼='$pass', 電話='$te', email='$mail', 
                      身分證ID='$ss' where 帳號='$ac'");
        $conn->query("update 獎助單位 set 聯絡人='$con' where 獎助單位帳號='$ac'");
    }    
    echo"修改成功";
    ?>
    <br>
    <button onclick="location.href='adminPage.php'">回首頁</button>
    <?php   
}