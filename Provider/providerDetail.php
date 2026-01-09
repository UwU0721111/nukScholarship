<?php
session_start();
include_once __DIR__ . '/../dbHandler.inc.php';

// 獲取申請編號和審查階段
$applicationId = isset($_GET['id']) ? $_GET['id'] : '';
$stage = isset($_GET['stage']) ? $_GET['stage'] : 'first';
$providerAccount = isset($_SESSION['account']) ? $_SESSION['account'] : '';

if (!$applicationId) {
    die("申請編號不存在");
}

$applicationIdEsc = mysqli_real_escape_string($conn, $applicationId);
$providerAccountEsc = mysqli_real_escape_string($conn, $providerAccount);

// 獲取申請資料詳情
$sql = "
SELECT 
    申請資料.申請編號,
    申請資料.申請日期,
    申請資料.學生帳號,
    使用者.姓名 AS 學生姓名,
    申請資料.名稱 AS 獎學金名稱,
    申請資料.自傳,
    申請資料.成績單編號,
    成績單.學期,
    成績單.學分數,
    成績單.排名,
    成績單.學業平均,
    成績單.GPA
FROM 申請資料
LEFT JOIN 使用者 ON 申請資料.學生帳號 = 使用者.帳號
LEFT JOIN 成績單 ON 申請資料.成績單編號 = 成績單.成績單編號
WHERE 申請資料.申請編號 = '" . $applicationIdEsc . "'
AND 申請資料.獎助單位帳號 = '" . $providerAccountEsc . "'
";

$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) === 0) {
    die("申請資料不存在或無權限訪問");
}

$application = mysqli_fetch_assoc($result);

// 獲取推薦信
$sql_recommendation = "
SELECT 推薦信.內容, 推薦信.日期, 推薦信.老師帳號, 使用者.姓名 AS 老師姓名
FROM 推薦信
LEFT JOIN 使用者 ON 推薦信.老師帳號 = 使用者.帳號
WHERE 推薦信.申請編號 = '" . $applicationIdEsc . "'
";

$result_recommendation = mysqli_query($conn, $sql_recommendation);
$recommendations = [];
if ($result_recommendation) {
    while ($row = mysqli_fetch_assoc($result_recommendation)) {
        $recommendations[] = $row;
    }
}

// 獲取審查記錄（如果有）
$sql_review = "
SELECT 初審日期, 初審結果, 複審日期, 是否核准
FROM 審查
WHERE 申請編號 = '" . $applicationIdEsc . "'
";

$result_review = mysqli_query($conn, $sql_review);
$review = null;
if ($result_review && mysqli_num_rows($result_review) > 0) {
    $review = mysqli_fetch_assoc($result_review);
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申請資料詳情</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-top: 30px;
        }
        .info-group {
            background-color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }
        .value {
            flex: 1;
            word-break: break-all;
        }
        .full-width {
            width: 100%;
        }
        .recommendation {
            background-color: #f0f0f0;
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #007bff;
            border-radius: 3px;
        }
        .form-group {
            margin: 20px 0;
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #555;
        }
        .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-family: Arial, sans-serif;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .button-group {
            text-align: center;
            margin-top: 30px;
        }
        button {
            padding: 10px 20px;
            margin: 0 10px;
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
    </style>
</head>
<body>
    <h1>申請資料詳情與審查</h1>

    <div class="info-group">
        <h2>基本申請資料</h2>
        <div class="info-row">
            <div class="label">申請編號</div>
            <div class="value"><?php echo htmlspecialchars($application['申請編號'], ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div class="info-row">
            <div class="label">申請日期</div>
            <div class="value"><?php echo htmlspecialchars($application['申請日期'], ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div class="info-row">
            <div class="label">學生帳號</div>
            <div class="value"><?php echo htmlspecialchars($application['學生帳號'], ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div class="info-row">
            <div class="label">學生姓名</div>
            <div class="value"><?php echo htmlspecialchars($application['學生姓名'], ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div class="info-row">
            <div class="label">獎學金名稱</div>
            <div class="value"><?php echo htmlspecialchars($application['獎學金名稱'], ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
    </div>

    <div class="info-group">
        <h2>成績單資料</h2>
        <?php if ($application['成績單編號']) { ?>
            <div class="info-row">
                <div class="label">成績單編號</div>
                <div class="value"><?php echo htmlspecialchars($application['成績單編號'], ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <div class="info-row">
                <div class="label">學期</div>
                <div class="value"><?php echo htmlspecialchars($application['學期'], ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <div class="info-row">
                <div class="label">學分數</div>
                <div class="value"><?php echo htmlspecialchars($application['學分數'], ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <div class="info-row">
                <div class="label">排名</div>
                <div class="value"><?php echo htmlspecialchars($application['排名'], ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <div class="info-row">
                <div class="label">學業平均</div>
                <div class="value"><?php echo htmlspecialchars($application['學業平均'], ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
            <div class="info-row">
                <div class="label">GPA</div>
                <div class="value"><?php echo htmlspecialchars($application['GPA'], ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
        <?php } else { ?>
            <p>無成績單資料</p>
        <?php } ?>
    </div>

    <div class="info-group">
        <h2>自傳</h2>
        <?php echo htmlspecialchars($application['自傳'], ENT_QUOTES, 'UTF-8'); ?>
        
    </div>

    <div class="info-group">
        <h2>推薦信</h2>
        <?php if (count($recommendations) > 0) { ?>
            <?php foreach ($recommendations as $rec) { ?>
                <div class="recommendation">
                    <div class="info-row">
                        <div class="label">老師姓名</div>
                        <div class="value"><?php echo htmlspecialchars($rec['老師姓名'], ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="label">日期</div>
                        <div class="value"><?php echo htmlspecialchars($rec['日期'], ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="label">內容</div>
                            <?php echo htmlspecialchars($rec['內容'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>無推薦信</p>
        <?php } ?>
    </div>

    <form action="providerHandler.inc.php" method="POST">
        <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($application['申請編號'], ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="stage" value="<?php echo htmlspecialchars($stage, ENT_QUOTES, 'UTF-8'); ?>">

        <div class="form-group">
            <label for="result">審查結果：</label>
            <select id="result" name="result" required>
                <option value="">-- 請選擇 --</option>
                <option value="通過">通過</option>
                <option value="不通過">不通過</option>
            </select>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-submit">送出審查結果</button>
            <button type="button" class="btn-cancel" onclick="location.href='providerPage.php'">返回</button>
        </div>
    </form>

</body>
</html>
