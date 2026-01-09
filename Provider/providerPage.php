<?php
session_start();
include_once __DIR__ . '/../dbHandler.inc.php';

// 獲取獎助單位帳號
$providerAccount = isset($_SESSION['account']) ? $_SESSION['account'] : '';
$providerAccountEsc = mysqli_real_escape_string($conn, $providerAccount);

// 獲取尚未初審的申請（沒有審查記錄）
$sql_pending = "
SELECT 
    申請資料.申請編號,
    申請資料.申請日期,
    申請資料.學生帳號,
    使用者.姓名 AS 學生姓名,
    申請資料.名稱 AS 獎學金名稱,
    申請資料.成績單編號
FROM 申請資料
LEFT JOIN 使用者 ON 申請資料.學生帳號 = 使用者.帳號
LEFT JOIN 審查 ON 申請資料.申請編號 = 審查.申請編號
WHERE 申請資料.獎助單位帳號 = '" . $providerAccountEsc . "'
AND 審查.申請編號 IS NULL
ORDER BY 申請資料.申請日期 ASC
";

// 獲取初審通過，尚未複審的申請
$sql_first_pass = "
SELECT 
    申請資料.申請編號,
    申請資料.申請日期,
    申請資料.學生帳號,
    使用者.姓名 AS 學生姓名,
    申請資料.名稱 AS 獎學金名稱,
    審查.初審日期,
    審查.初審結果,
    申請資料.成績單編號
FROM 申請資料
LEFT JOIN 使用者 ON 申請資料.學生帳號 = 使用者.帳號
LEFT JOIN 審查 ON 申請資料.申請編號 = 審查.申請編號
WHERE 申請資料.獎助單位帳號 = '" . $providerAccountEsc . "'
AND 審查.初審結果 = '通過'
AND (審查.是否核准 IS NULL OR 審查.是否核准 = '')
ORDER BY 審查.初審日期 ASC
";

$result_pending = mysqli_query($conn, $sql_pending);
$result_first_pass = mysqli_query($conn, $sql_first_pass);

if (!$result_pending || !$result_first_pass) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>獎助單位頁面</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        button {
            padding: 5px 15px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>獎助單位審查系統</h1>
    
    <h2>尚未初審的申請</h2>
    <?php if (mysqli_num_rows($result_pending) > 0) { ?>
        <table>
            <tr>
                <th>申請編號</th>
                <th>申請日期</th>
                <th>學生帳號</th>
                <th>學生姓名</th>
                <th>獎學金名稱</th>
                <th>操作</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result_pending)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['申請編號'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['申請日期'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['學生帳號'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['學生姓名'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['獎學金名稱'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <form action="providerDetail.php" method="get" style="margin:0;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['申請編號'], ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="stage" value="first">
                            <button type="submit">審查</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p class="no-data">目前沒有尚未初審的申請</p>
    <?php } ?>

    <h2>初審通過，尚未複審的申請</h2>
    <?php if (mysqli_num_rows($result_first_pass) > 0) { ?>
        <table>
            <tr>
                <th>申請編號</th>
                <th>申請日期</th>
                <th>學生帳號</th>
                <th>學生姓名</th>
                <th>獎學金名稱</th>
                <th>初審日期</th>
                <th>操作</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result_first_pass)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['申請編號'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['申請日期'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['學生帳號'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['學生姓名'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['獎學金名稱'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['初審日期'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <form action="providerDetail.php" method="get" style="margin:0;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['申請編號'], ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="stage" value="second">
                            <button type="submit">審查</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p class="no-data">目前沒有初審通過尚未複審的申請</p>
    <?php } ?>

    <br>
    <button onclick="location.href='../logout.inc.php'">登出</button>
</body>
</html>