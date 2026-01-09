<?php
session_start();
include_once __DIR__ . '/../dbHandler.inc.php';

// 获取老师账号
$teacherAccount = isset($_SESSION['account']) ? $_SESSION['account'] : '';
$teacherAccountEsc = mysqli_real_escape_string($conn, $teacherAccount);

// 获取老师的科系
$sqlTeacher = "SELECT 科系 FROM 老師 WHERE 老師帳號 = '" . $teacherAccountEsc . "'";
$resultTeacher = mysqli_query($conn, $sqlTeacher);
$teacher = mysqli_fetch_assoc($resultTeacher);
$majorDept = $teacher ? $teacher['科系'] : '';

// 获取同科系的学生列表
$sqlStudents = "
SELECT DISTINCT 學生.學生帳號, 使用者.姓名
FROM 學生
LEFT JOIN 使用者 ON 學生.學生帳號 = 使用者.帳號
WHERE 學生.系所 = '" . mysqli_real_escape_string($conn, $majorDept) . "'
ORDER BY 學生.學生帳號
";
$resultStudents = mysqli_query($conn, $sqlStudents);
$students = [];
while ($row = mysqli_fetch_assoc($resultStudents)) {
    $students[] = $row;
}

// 获取选中学生的申请信息
$selectedStudentAccount = isset($_POST['student_account']) ? $_POST['student_account'] : '';
$selectedStudentAccountEsc = mysqli_real_escape_string($conn, $selectedStudentAccount);
$applications = [];

if ($selectedStudentAccount !== '') {
    // 查询该学生尚未有推荐信的申请
    $sqlApps = "
    SELECT 申請資料.申請編號, 申請資料.名稱 AS 獎學金名稱
    FROM 申請資料
    LEFT JOIN 推薦信 ON 申請資料.申請編號 = 推薦信.申請編號 AND 推薦信.老師帳號 = '" . $teacherAccountEsc . "'
    WHERE 申請資料.學生帳號 = '" . $selectedStudentAccountEsc . "'
    AND 推薦信.申請編號 IS NULL
    ORDER BY 申請資料.申請日期 DESC
    ";
    $resultApps = mysqli_query($conn, $sqlApps);
    while ($row = mysqli_fetch_assoc($resultApps)) {
        $applications[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>推薦信頁面</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        select, textarea {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-family: Arial, sans-serif;
        }
        select {
            width: 300px;
        }
        textarea {
            width: 100%;
            min-height: 150px;
            resize: vertical;
        }
        button {
            padding: 10px 20px;
            margin-right: 10px;
            cursor: pointer;
            border: none;
            border-radius: 3px;
            font-size: 14px;
        }
        .btn-submit {
            background-color: #28a745;
            color: white;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }
        .btn-cancel:hover {
            background-color: #5a6268;
        }
        .message {
            color: #d9534f;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>填寫推薦信</h1>

    <?php if ($majorDept === '') { ?>
        <p class="message">無法取得教師資訊，請重新登入</p>
    <?php } else { ?>
        <form action="recommendation.php" method="POST">
            <div class="form-group">
                <label for="student_account">選擇學生（同科系）：</label>
                <select id="student_account" name="student_account" required onchange="this.form.submit();">
                    <option value="">-- 請選擇學生 --</option>
                    <?php foreach ($students as $stu) { ?>
                        <option value="<?php echo htmlspecialchars($stu['學生帳號'], ENT_QUOTES, 'UTF-8'); ?>"
                            <?php echo ($selectedStudentAccount === $stu['學生帳號']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($stu['學生帳號'] . ' - ' . $stu['姓名'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </form>

        <?php if ($selectedStudentAccount !== '') { ?>
            <form action="recomHandler.inc.php" method="POST">
                <div class="form-group">
                    <label for="appNumber">選擇申請編號：</label>
                    <?php if (count($applications) > 0) { ?>
                        <select id="appNumber" name="appNumber" required>
                            <option value="">-- 請選擇申請編號 --</option>
                            <?php foreach ($applications as $app) { ?>
                                <option value="<?php echo htmlspecialchars($app['申請編號'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($app['申請編號'] . ' - ' . $app['獎學金名稱'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php } ?>
                        </select>
                    <?php } else { ?>
                        <p style="color: #d9534f;">該學生沒有尚未審核的申請，或已填寫推薦信</p>
                    <?php } ?>
                </div>

                <?php if (count($applications) > 0) { ?>
                    <div class="form-group">
                        <label for="content">推薦信內容：</label>
                        <textarea id="content" name="content" required></textarea>
                    </div>

                    <div>
                        <button type="submit" name="button" value="submit" class="btn-submit">送出推薦信</button>
                        <button type="submit" name="button" value="cancel" class="btn-cancel" formnovalidate>取消</button>
                    </div>
                <?php } ?>
            </form>
        <?php } ?>
    <?php } ?>

</body>
</html>