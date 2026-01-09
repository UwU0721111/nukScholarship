<?php
date_default_timezone_set('Asia/Taipei');
session_start();
include_once __DIR__ . '/../dbhandler.inc.php';


// 接收表單資料
$applyId   = mysqli_real_escape_string($conn, $_POST['apply_id']);
$name      = mysqli_real_escape_string($conn, $_POST['scholarship_name']);
$account   = mysqli_real_escape_string($conn, $_POST['student_account']);
$date      = mysqli_real_escape_string($conn, $_POST['apply_date']);
$autobio   = mysqli_real_escape_string($conn, $_POST['autobiography']);

// 檢查是否已有這筆申請編號
$sqlCheck = "SELECT 申請編號 FROM 申請資料 WHERE 申請編號 = '$applyId'";
$resultCheck = mysqli_query($conn, $sqlCheck);

if (mysqli_num_rows($resultCheck) > 0) {
    // 已存在 → 更新
    $sqlUpdate = "
        UPDATE 申請資料
        SET 名稱='$name',
            學生帳號='$account',
            申請日期='$date',
            自傳='$autobio'
        WHERE 申請編號='$applyId'
    ";
    mysqli_query($conn, $sqlUpdate) or die("更新失敗: " . mysqli_error($conn));
    echo "申請資料已更新成功！";
} else {
    // 不存在 → 新增
    $sqlInsert = "
        INSERT INTO 申請資料 (申請編號, 名稱, 學生帳號, 申請日期, 自傳)
        VALUES ('$applyId', '$name', '$account', '$date', '$autobio')
    ";
    mysqli_query($conn, $sqlInsert) or die("新增失敗: " . mysqli_error($conn));
    echo "申請資料已新增成功！";
}
?>
