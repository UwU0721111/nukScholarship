<?php
session_start();
include_once __DIR__ . '/../dbhandler.inc.php';

// 從 session 取得學生帳號
$studentAccount = isset($_SESSION['account']) ? $_SESSION['account'] : '';
$studentAccountEsc = mysqli_real_escape_string($conn, $studentAccount);

$sql = "
SELECT 
    申請資料.名稱 AS 獎學金名稱,
    申請資料.申請編號,
    申請資料.學生帳號,
    使用者.姓名 AS 學生姓名,
    申請資料.申請日期,
    審查.初審日期,
    審查.初審結果,
    審查.複審日期,
    審查.是否核准,
    申請資料.成績單編號
FROM 申請資料
LEFT JOIN 使用者 ON 申請資料.學生帳號 = 使用者.帳號
LEFT JOIN 審查 ON 申請資料.申請編號 = 審查.申請編號
WHERE 申請資料.學生帳號 = '" . $studentAccountEsc . "'
ORDER BY 申請資料.申請日期 DESC
";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>申請資料列表</title>
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #666;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
            width: 30%;
        }
    </style>
</head>
<body>
    <h2>申請資料列表</h2>

    <?php if (mysqli_num_rows($result) > 0) { ?>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <table>
                <tr>
                    <th>獎學金名稱</th>
                    <td><?php echo htmlspecialchars($row['獎學金名稱'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <th>申請編號</th>
                    <td><?php echo htmlspecialchars($row['申請編號'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <th>學生姓名</th>
                    <td><?php echo htmlspecialchars($row['學生姓名'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <th>學生帳號</th>
                    <td><?php echo htmlspecialchars($row['學生帳號'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <th>申請日期</th>
                    <td colspan="3"><?php echo htmlspecialchars($row['申請日期'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <th>初審日期</th>
                    <td><?php echo htmlspecialchars($row['初審日期'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <th>初審結果</th>
                    <td><?php echo htmlspecialchars($row['初審結果'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <th>複審日期</th>
                    <td><?php echo htmlspecialchars($row['複審日期'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <th>是否核准</th>
                    <td><?php echo htmlspecialchars($row['是否核准'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <th>成績單編號</th>
                    <td colspan="3"><?php echo htmlspecialchars($row['成績單編號'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            </table>
        <?php } ?>
    <?php } else { ?>
        <p>目前查無此學生的申請資料。</p>
    <?php } ?>
</body>
</html>
