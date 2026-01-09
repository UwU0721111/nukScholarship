<?php
date_default_timezone_set('Asia/Taipei');

session_start();
include_once __DIR__ . '/../dbhandler.inc.php';


// 假設登入後把學生帳號存到 session
$studentAccount = isset($_SESSION['account']) ? $_SESSION['account'] : '';

// 查詢學生基本資料
$sqlStudent = "
SELECT 使用者.姓名, 使用者.帳號, 使用者.電話, 使用者.email, 使用者.身分證ID
FROM 使用者
WHERE 使用者.帳號 = '" . mysqli_real_escape_string($conn, $studentAccount) . "'
";
$resultStudent = mysqli_query($conn, $sqlStudent);
$student = mysqli_fetch_assoc($resultStudent);

// 查詢監護人資料（若有多筆只取第一筆）
$sqlGuardian = "
SELECT 姓名, 關係
FROM 監護人
WHERE 學生帳號 = '" . mysqli_real_escape_string($conn, $studentAccount) . "'
LIMIT 1
";
$resultGuardian = mysqli_query($conn, $sqlGuardian);
$guardian = mysqli_fetch_assoc($resultGuardian);

// 若是修改既有申請，從 URL 取得申請編號並載入資料
$applyId = isset($_GET['id']) ? $_GET['id'] : '';
$apply = null;
if ($applyId !== '') {
    $sqlApply = "
    SELECT 名稱, 申請編號, 自傳, 申請日期, 成績單編號, 獎助單位帳號
    FROM 申請資料
    WHERE 申請編號 = '" . mysqli_real_escape_string($conn, $applyId) . "'
    LIMIT 1
    ";
    $resultApply = mysqli_query($conn, $sqlApply);
    $apply = mysqli_fetch_assoc($resultApply);
}

// 如果是新增申請，產生新的申請編號 (格式 APP0001, APP0002 ...)
$newApplyId = '';
if ($applyId === '') {
    $sqlMax = "SELECT MAX(申請編號) AS max_id FROM 申請資料";
    $resultMax = mysqli_query($conn, $sqlMax);
    $rowMax = mysqli_fetch_assoc($resultMax);

    if ($rowMax && $rowMax['max_id'] !== null) {
        // 去掉前綴 APP，取數字部分
        $numPart = intval(substr($rowMax['max_id'], 3));
        $nextNum = $numPart + 1;
        // 補零到 4 位數
        $newApplyId = 'APP' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
    } else {
        // 如果資料表還沒有任何申請，從 APP0001 開始
        $newApplyId = 'APP0001';
    }
}

// 查詢該學生的所有成績單
$sqlTranscript = "
SELECT 成績單編號, 學期
FROM 成績單
WHERE 學生帳號 = '" . mysqli_real_escape_string($conn, $studentAccount) . "'
ORDER BY 學期 DESC
";
$resultTranscript = mysqli_query($conn, $sqlTranscript);
$transcripts = [];
$defaultTranscriptId = '';
if ($resultTranscript) {
    while ($row = mysqli_fetch_assoc($resultTranscript)) {
        $transcripts[] = $row;
        if ($defaultTranscriptId === '') {
            $defaultTranscriptId = $row['成績單編號'];
        }
    }
}

// 查詢所有可申請的獎學金及其提供單位
$sqlScholarships = "
SELECT 獎學金.名稱, 獎學金.獎助單位帳號
FROM 獎學金
ORDER BY 獎學金.名稱
";
$resultScholarships = mysqli_query($conn, $sqlScholarships);
$scholarships = [];
while ($row = mysqli_fetch_assoc($resultScholarships)) {
    $scholarships[] = $row;
}
$defaultDate = date('Y-m-d');
$applyDate = (isset($apply['申請日期']) && $apply['申請日期'] !== '') ? $apply['申請日期'] : $defaultDate;

// 安全輸出用的 helper（PHP 5 相容）
function e($str) {
    return htmlspecialchars(isset($str) ? $str : '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>申請書填寫/修改</title>
    <style>
        table {
            border-collapse: collapse;
            width: 70%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #666;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
            width: 25%;
        }
        textarea {
            width: 100%;
            height: 120px; /* 約 5 行 */
            resize: vertical; /* 可垂直調整大小 */
        }
        .submit-btn {
            padding: 8px 16px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>申請書填寫/修改</h2>

    <form action="apply_save.php" method="post">
        <table>
            <tr>
                <th>獎學金名稱</th>
                <td>
                    <select name="scholarship_name" id="scholarship_name" required onchange="updateProviderAccount()">
                        <option value="">-- 請選擇 --</option>
                        <?php foreach ($scholarships as $sch) { ?>
                            <option value="<?php echo e($sch['名稱']); ?>" data-provider="<?php echo e($sch['獎助單位帳號']); ?>"
                                <?php echo (isset($apply['名稱']) && $apply['名稱'] === $sch['名稱']) ? 'selected' : ''; ?>>
                                <?php echo e($sch['名稱']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <th>申請編號</th>
                <td><?php echo e($applyId !== '' ? $apply['申請編號'] : $newApplyId); ?></td>
            </tr>
            <tr>
                <th>學生姓名</th>
                <td><?php echo e(isset($student['姓名']) ? $student['姓名'] : ''); ?></td>
                <th>學生帳號</th>
                <td><?php echo e(isset($student['帳號']) ? $student['帳號'] : ''); ?></td>
            </tr>
            <tr>
                <th>成績單編號</th>
                <td colspan="3">
                    <?php if (count($transcripts) > 0) { ?>
                        <select name="transcript_id" id="transcript_id">
                            <option value="">-- 請選擇成績單 --</option>
                            <?php foreach ($transcripts as $trans) { ?>
                                <option value="<?php echo e($trans['成績單編號']); ?>"
                                    <?php echo (isset($apply['成績單編號']) && $apply['成績單編號'] === $trans['成績單編號']) ? 'selected' : ''; ?>>
                                    <?php echo e($trans['成績單編號'] . ' (' . $trans['學期'] . ')'); ?>
                                </option>
                            <?php } ?>
                        </select>
                    <?php } else { ?>
                        <span style="color: red;">尚無成績單記錄</span>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <th>申請日期</th>
                <td colspan="3">
                    <?php echo e($applyDate); ?>
                </td>
            </tr>
            <tr>
                <th>電話</th>
                <td><?php echo e(isset($student['電話']) ? $student['電話'] : ''); ?></td>
                <th>Email</th>
                <td><?php echo e(isset($student['email']) ? $student['email'] : ''); ?></td>
            </tr>
            <tr>
                <th>身分證ID</th>
                <td colspan="3"><?php echo e(isset($student['身分證ID']) ? $student['身分證ID'] : ''); ?></td>
            </tr>
            <tr>
                <th>監護人</th>
                <td colspan="3">
                    <?php
                        if ($guardian && isset($guardian['姓名'])) {
                            echo e($guardian['姓名']) . '（' . e(isset($guardian['關係']) ? $guardian['關係'] : '') . '）';
                        } else {
                            echo '尚未填寫';
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th>自傳</th>
                <td colspan="3">
                    <textarea name="autobiography"><?php echo e(isset($apply['自傳']) ? $apply['自傳'] : ''); ?></textarea>
                </td>
            </tr>
        </table>

        <!-- 帶上學生帳號，供存檔使用 -->
        <input type="hidden" name="student_account" value="<?php echo e(isset($student['帳號']) ? $student['帳號'] : $studentAccount); ?>">
        <!-- 帶上獎助單位帳號 -->
        <input type="hidden" name="provider_account" id="provider_account" value="">
        <!-- 帶上申請編號 -->
        <input type="hidden" name="apply_id" value="<?php echo e($applyId !== '' ? $apply['申請編號'] : $newApplyId); ?>">
        <!-- 帶上申請日期 -->
        <input type="hidden" name="apply_date" value="<?php echo e($applyDate); ?>">
        <!-- 帶上成績單編號 -->
        <input type="hidden" name="transcript_id" value="<?php echo e(isset($apply['成績單編號']) && $apply['成績單編號'] !== '' ? $apply['成績單編號'] : $defaultTranscriptId); ?>">
        
        <button type="submit" class="submit-btn">送出申請</button>
    </form>
    <button class="submit-btn" onclick="location.href='../Student/studentPage.php'">取消</button>

    <script>
    // 初始化獎助單位帳號
    function updateProviderAccount() {
        var select = document.getElementById('scholarship_name');
        var option = select.options[select.selectedIndex];
        var provider = option.getAttribute('data-provider');
        document.getElementById('provider_account').value = provider || '';
    }
    
    // 同步成績單編號
    function updateTranscriptId() {
        var select = document.getElementById('transcript_id');
        var transcriptIdHidden = document.querySelector('input[name="transcript_id"]');
        if (select && transcriptIdHidden) {
            transcriptIdHidden.value = select.value;
        }
    }
    
    // 頁面載入時執行
    window.onload = function() {
        updateProviderAccount();
        updateTranscriptId();
    };
    
    // 成績單變化時更新隱藏字段
    document.addEventListener('change', function(e) {
        if (e.target.id === 'transcript_id') {
            updateTranscriptId();
        }
    });
    </script>
</body>
</html>
