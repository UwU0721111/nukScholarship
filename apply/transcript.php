<?php
date_default_timezone_set('Asia/Taipei');
session_start();
include_once __DIR__ . '/../dbhandler.inc.php';


// 從 session 取得登入的學生帳號
$studentAccount = isset($_SESSION['account']) ? $_SESSION['account'] : '';

// 安全輸出 helper
function e($str) {
    return htmlspecialchars(isset($str) ? $str : '', ENT_QUOTES, 'UTF-8');
}

// 抓該學生最新一份成績單
$sqlTranscript = "
SELECT 成績單編號, 學期, 學分數, 排名, 學業平均, GPA
FROM 成績單
WHERE 學生帳號 = '" . mysqli_real_escape_string($conn, $studentAccount) . "'
ORDER BY 學期 DESC
LIMIT 1
";
$resultTranscript = mysqli_query($conn, $sqlTranscript);
$transcript = mysqli_fetch_assoc($resultTranscript);

if (!$transcript) {
    echo "<p>目前查無此學生的成績單。</p>";
    exit;
}

// 查科目
$sqlCourses = "
SELECT k.課堂名稱, k.種類, k.分數
FROM 有 y
JOIN 科目 k ON y.課堂編號 = k.課堂編號
WHERE y.成績單編號 = '" . mysqli_real_escape_string($conn, $transcript['成績單編號']) . "'
";
$resultCourses = mysqli_query($conn, $sqlCourses);
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>成績單</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #666;
            padding: 8px;
        }
        th {
            background-color: #eee;
            text-align: center;
        }
        td {
            text-align: center;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>成績單 - 學生 <?php echo e($studentAccount); ?></h2>
    <table>
        <!-- 第一列：成績單編號、學期 -->
        <tr>
            <th>成績單編號</th>
            <td><?php echo e($transcript['成績單編號']); ?></td>
            <th>學期</th>
            <td><?php echo e($transcript['學期']); ?></td>
        </tr>

        <!-- 科目列表 -->
        <?php if ($resultCourses && mysqli_num_rows($resultCourses) > 0) { ?>
            <?php while ($course = mysqli_fetch_assoc($resultCourses)) { ?>
            <tr>
                <td class="bold"><?php echo e($course['課堂名稱']); ?></td>
                <td><?php echo e($course['種類']); ?></td>
                <td class="bold">成績</td>
                <td><?php echo e($course['分數']); ?></td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="4">此成績單未查到修課資料。</td>
            </tr>
        <?php } ?>

        <!-- 總結資訊 -->
        <tr>
            <th>學分數</th>
            <td><?php echo e($transcript['學分數']); ?></td>
            <th>排名</th>
            <td><?php echo e($transcript['排名']); ?></td>
        </tr>
        <tr>
            <th>學業平均</th>
            <td><?php echo e($transcript['學業平均']); ?></td>
            <th>GPA</th>
            <td><?php echo e($transcript['GPA']); ?></td>
        </tr>
    </table>
</body>
</html>
