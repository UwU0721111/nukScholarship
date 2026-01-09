<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>公告管理</title>
    <style>
        body {
            background-color: #f0f0f0; /* 1. 淺灰色背景 */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h3 {
            text-align: center; /* 2. 標題置中 */
            margin-top: 24px;
            margin-bottom: 16px;
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 80%;
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
        textarea {
            width: 60%;
            margin: 10px auto;
            display: block;
            resize: vertical;
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
    <h3>公告</h3><br>
    <?php
    require_once "../dbHandler.inc.php";
    $result=$conn->query("select 日期, 內容 from 公告 order by 公告編號 desc");
    ?>
    <table>
        <tr>
            <th>日期</th>
            <th>內容</th>
        </tr>
    <?php
    foreach($result as $row){
        echo "<tr>";
        echo "<td>".htmlspecialchars($row['日期'])."</td>";
        echo "<td>".htmlspecialchars($row['內容'])."</td>";  
        echo "</tr>";     
    }
    ?>
    </table><br>

    <h3>發布新公告</h3><br>
    <form action="annonHandler.inc.php" method="POST">
        <label style="display:block; text-align:center;">內容：</label>
        <textarea name="content" cols="50" rows="5"></textarea><br>
        <div class="buttons">
            <button name="button" value="cancel" class="btn cancel-btn">取消</button>        
            <button name="button" value="submit" class="btn submit-btn">送出</button>
        </div>
    </form>
</body>
</html>
