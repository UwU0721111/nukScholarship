<?php
session_start();
?> 
<?php
date_default_timezone_set('Asia/Taipei');
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if($_POST['button']=="cancel"){
        header("Location: teacherPage.php");
        exit();
    }  
    $appNumber=$_POST['appNumber'];
    $content=$_POST['content'];

    require_once "../dbHandler.inc.php";
    $username=$_SESSION['username'];
    $currentDate = date('Y-m-d');
    $result=$conn->query("insert into 推薦信 (內容,日期,老師帳號,申請編號) 
                         VALUES('$content','$currentDate','$username','$appNumber')");
    if($result){
        echo"送出成功";
        ?>
        <br>
        <button onclick="location.href='teacherPage.php'">回首頁</button>
        <?php
    }
}