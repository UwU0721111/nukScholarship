<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>推薦信頁面</title>
</head>
<body>
    <form action="recomHandler.inc.php" method="POST">
        <label>申請編號：</label>
        <input type="text" name="appNumber"><br>
        <label>內容：</label>
        <input type="text" name="content" size="100"><br>
        <button name="button" value="cancel">取消</button>        
        <button name="button" value="submit">送出</button>
    </form>
</body>
</html>