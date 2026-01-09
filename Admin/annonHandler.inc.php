<?php
session_start();
?> 
<?php
date_default_timezone_set('Asia/Taipei');
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if($_POST['button']=="cancel"){
        header("Location: adminPage.php");
        exit();
    }  
    $content=$_POST['content'];

    require_once "../dbHandler.inc.php";
    $username=$_SESSION['username'];
    $currentDate = date('Y-m-d');

    $annonId = '';   
    $sqlMax = "SELECT MAX(公告編號) AS max_id FROM 公告";
    $resultMax = mysqli_query($conn, $sqlMax);
    $rowMax = mysqli_fetch_assoc($resultMax);

    if ($rowMax && $rowMax['max_id'] !== null) {
        // 去掉前綴 N，取數字部分
        $numPart = intval(substr($rowMax['max_id'], 1));
        $nextNum = $numPart + 1;
        // 補零到 3 位數
        $annonId = 'N' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
    } else {
        // 如果還沒有任何公告，從 N001 開始
        $annonId = 'APP0001';
    }

    $result=$conn->query("insert into 公告 (公告編號,日期,內容,管理員帳號) 
                         VALUES('$annonId','$currentDate','$content','$username')");
    if($result){
        echo"送出成功";
        ?>
        <br>
        <button onclick="location.href='adminPage.php'">回首頁</button>
        <?php
    }
}