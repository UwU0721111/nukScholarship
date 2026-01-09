<?php
session_start();
?> 
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if($_POST['button']=="cancel"){
        header("Location: adminPage.php");
        exit();
    }
    $name=$_POST['name'];       
    $req=$_POST['req'];
    $amount=$_POST['amount'];
    $deadline=$_POST['deadline'];
    $quota=$_POST['quota'];
    $acc=$_POST['acc'];
    $count=count($req);
    require_once "../dbHandler.inc.php";
    for($i=0;$i<$count;$i++)
    {
        $na=$name[$i];       
        $re=$req[$i];
        $am=$amount[$i];
        $dead=$deadline[$i];
        $quo=$quota[$i];
        $ac=$acc[$i];
        $conn->query("update 獎學金 set 補助金額='$am', 期限='$dead',
                      名額='$quo' where 獎助單位帳號='$ac' and 名稱='$na'");
        $conn->query("update 獎學金_條件 set 條件='$re'
                      where 獎助單位帳號='$ac' and 名稱='$na'");
    }    
    echo"修改成功";
    ?>
    <br>
    <button onclick="location.href='adminPage.php'">回首頁</button>
    <?php   
}