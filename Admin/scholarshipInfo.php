<?php
session_start();
?> 
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>獎助學金資料管理</title>
    <style>
        body {
            background-color: #f0f0f0; /* 淺灰色背景 */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center; /* 標題置中 */
            margin-top: 24px;
            margin-bottom: 16px;
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto; /* 表格置中 */
        }
        th, td {
            border: 1px solid #666;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        .btn {
            padding: 8px 16px;
            margin: 0 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }
        .submit-btn {
            background-color: #4CAF50;
        }
        .submit-btn:hover {
            background-color: #45a049;
        }
        .cancel-btn {
            background-color: #d9534f;
        }
        .cancel-btn:hover {
            background-color: #c9302c;
        }
        .buttons {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>獎助學金資料管理</h2>
    <?php
    require_once "../dbHandler.inc.php";
    $result=$conn->query("select * from 獎學金_條件 natural join 獎學金");
    ?>
    <form action="scholarshipInfoHandler.inc.php" method="POST">
        <table>
            <tr>
                <th>名稱</th>
                <th>條件</th>
                <th>補助金額</th>
                <th>期限</th>
                <th>名額</th>
                <th>獎助單位帳號</th>
            </tr>
        <?php
        foreach($result as $row){
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row['名稱']);?></td>
                <input type="hidden" name="name[]" value="<?php echo htmlspecialchars($row['名稱']);?>">
                <td><input type="text" name="req[]" size="30" value="<?php echo htmlspecialchars($row['條件']);?>"></td>
                <td><input type="text" name="amount[]" size="5" value="<?php echo htmlspecialchars($row['補助金額']);?>"></td>
                <td><input type="text" name="deadline[]" size="7" value="<?php echo htmlspecialchars($row['期限']);?>"></td>
                <td><input type="text" name="quota[]" size="2" value="<?php echo htmlspecialchars($row['名額']);?>"></td>
                <td><?php echo htmlspecialchars($row['獎助單位帳號']);?></td>
                <input type="hidden" name="acc[]" value="<?php echo htmlspecialchars($row['獎助單位帳號']);?>">
            </tr>  
        <?php 
        }
        ?>
        </table>
        <div class="buttons">
            <button name="button" value="submit" class="btn submit-btn">修改</button>
            <button name="button" value="cancel" class="btn cancel-btn">取消</button>
        </div>
    </form>   
</body>
</html>
