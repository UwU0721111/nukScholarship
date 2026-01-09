<?php
session_start();
?> 
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>獎助單位資料管理</title>
    <style>
        body {
            background-color: #f0f0f0; /* 1. 淺灰色背景 */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center; /* 2. 標題置中 */
            margin-top: 24px;
            margin-bottom: 16px;
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto; /* 2. 表格置中 */
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
            text-align: center; /* 3. 按鈕置中並排 */
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>獎助單位資料管理</h2>
    <?php
    require_once "../dbHandler.inc.php";
    $result=$conn->query("select * from 獎助單位, 使用者 where 帳號=獎助單位帳號");
    ?>
    <form action="providerInfoHandler.inc.php" method="POST">
        <table>
            <tr>
                <th>帳號</th>
                <th>名稱</th>
                <th>聯絡人</th>       
                <th>密碼</th>
                <th>電話</th>
                <th>Email</th>
                <th>身分證ID</th>
            </tr>
        <?php
        foreach($result as $row){
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row['帳號']);?></td>
                <input type="hidden" name="acc[]" value="<?php echo htmlspecialchars($row['帳號']);?>">
                <td><input type="text" name="name[]" size="15" value="<?php echo htmlspecialchars($row['姓名']);?>"></td>
                <td><input type="text" name="contact[]" size="13" value="<?php echo htmlspecialchars($row['聯絡人']);?>"></td>
                <td><input type="text" name="pwd[]" size="10" value="<?php echo htmlspecialchars($row['密碼']);?>"></td>
                <td><input type="text" name="tel[]" size="10" value="<?php echo htmlspecialchars($row['電話']);?>"></td>
                <td><input type="text" name="email[]" size="25" value="<?php echo htmlspecialchars($row['email']);?>"></td>
                <td><input type="text" name="ssn[]" size="10" value="<?php echo htmlspecialchars($row['身分證ID']);?>"></td>
            </tr>  
        <?php 
        }
        ?>
        </table>
        <div class="buttons">
            <button name="button" value="cancel" class="btn cancel-btn">取消</button>        
            <button name="button" value="submit" class="btn submit-btn">修改</button>
        </div>
    </form>   
</body>
</html>
