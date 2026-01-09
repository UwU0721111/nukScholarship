<?php
session_start();
date_default_timezone_set('Asia/Taipei');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../dbHandler.inc.php";
    
    $applicationId = isset($_POST['application_id']) ? $_POST['application_id'] : '';
    $stage = isset($_POST['stage']) ? $_POST['stage'] : 'first';
    $result = isset($_POST['result']) ? $_POST['result'] : '';
    
    $providerAccount = isset($_SESSION['account']) ? $_SESSION['account'] : '';
    
    if (!$applicationId || !$result) {
        die("資料不完整");
    }
    
    $applicationIdEsc = mysqli_real_escape_string($conn, $applicationId);
    $resultEsc = mysqli_real_escape_string($conn, $result);
    $providerAccountEsc = mysqli_real_escape_string($conn, $providerAccount);
    $currentDate = date('Y-m-d');
    
    if ($stage === 'first') {
        // 初審階段：插入或更新審查記錄
        
        // 檢查是否已有審查記錄
        $sql_check = "SELECT * FROM 審查 WHERE 申請編號 = '" . $applicationIdEsc . "'";
        $result_check = mysqli_query($conn, $sql_check);
        
        if (mysqli_num_rows($result_check) > 0) {
            // 更新現有記錄
            $sql = "UPDATE 審查 
                    SET 初審日期 = '" . $currentDate . "', 
                        初審結果 = '" . $resultEsc . "'
                    WHERE 申請編號 = '" . $applicationIdEsc . "'
                        AND 獎助單位帳號 = '" . $providerAccountEsc . "'";
        } else {
            // 插入新記錄
            $sql = "INSERT INTO 審查 (初審日期, 初審結果, 獎助單位帳號, 申請編號)
                    VALUES ('" . $currentDate . "', '" . $resultEsc . "', '" . $providerAccountEsc . "', '" . $applicationIdEsc . "')";
        }
        
    } else {
        // 複審階段：更新是否核准
        $resultForDB = $resultEsc === '通過' ? '是' : '否';
        
        $sql = "UPDATE 審查 
                SET 複審日期 = '" . $currentDate . "', 
                    是否核准 = '" . $resultForDB . "'
                WHERE 申請編號 = '" . $applicationIdEsc . "'
                    AND 獎助單位帳號 = '" . $providerAccountEsc . "'";
    }
    
    if (mysqli_query($conn, $sql)) {
        // 成功，返回主頁面
        header("Location: providerPage.php");
        exit();
    } else {
        die("資料保存失敗：" . mysqli_error($conn));
    }
}
