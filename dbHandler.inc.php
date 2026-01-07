<?php

$db_server="localhost";
$db_user="root";
$db_pwd="";
$db_name="nukscholarship";
$conn="";

try{
    $conn=mysqli_connect(
        $db_server,
        $db_user,
        $db_pwd,
        $db_name
    );

} catch(mysqli_sql_exception){
    echo"not connected";
}