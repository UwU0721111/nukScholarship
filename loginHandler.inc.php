<?php
session_start();
?> 
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST["username"];
    $pwd=$_POST["pwd"];

    require_once "dbHandler.inc.php";
    $result=$conn->query("select * from 使用者 where 帳號='$username' and 密碼='$pwd'");
    if($result->num_rows>0){
        $user=$result->fetch_assoc();

	$_SESSION['username']=$username;
        $_SESSION['name']=$user['姓名'];
	$_SESSION['account'] = $user['帳號'];
        switch($user['種類']){
            case '學生':
                header("Location: Student/studentPage.php");
                break;
            case '老師':
                header("Location: Teacher/teacherPage.php");
                break;
            case '獎助單位':
                header("Location: Provider/providerPage.php");
                break;
            case '系統管理員':
                header("Location: Admin/adminPage.php");
        }
        
        exit();       
    }
    header("Location: index.php");
    exit();
}