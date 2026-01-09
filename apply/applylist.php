<?php
include_once __DIR__ . '/../dbhandler.inc.php';


$sql = "
SELECT 
    申請資料.名稱 AS 獎學金名稱,
    申請資料.申請編號
FROM 申請資料
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
    <title>申請者列表</title>
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
        }
        th, td {
            border: 1px solid #666;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        button {
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>申請者列表</h2>
    <table>
        <tr>
            <th>獎學金名稱</th>
            <th>申請編號</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['獎學金名稱']; ?></td>
            <td>
                <form action="applypage.php" method="get" style="margin:0;">
                    <input type="hidden" name="id" value="<?php echo $row['申請編號']; ?>">
                    <button type="submit"><?php echo $row['申請編號']; ?></button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
