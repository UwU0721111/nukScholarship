<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入</title>
    <style>
        body {
            background-color: #f0f0f0; /* 淺灰色背景 */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;   /* 置中標題 */
            margin-top: 50px;
            font-size: 28px;
            color: #333;
        }
        .container {
            text-align: center;   /* 置中表單 */
            margin-top: 50px;
        }
        form {
            display: inline-block;
            background: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: inline-block;
            width: 80px;
            text-align: right;
            margin-right: 10px;
        }
        input {
            padding: 8px;
            margin-bottom: 15px;
            width: 200px;
        }
        button {
            padding: 8px 20px;
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>高雄大學獎助學金系統</h1>
    <div class="container">
        <h3>登入</h3>
        <form action="loginHandler.inc.php" method="POST">
            <div>
                <label>帳號：</label>
                <input type="text" name="username">
            </div>
            <div>
                <label>密碼：</label>
                <input type="password" name="pwd">
            </div>
            <button type="submit">登入</button>
        </form>
    </div>
</body>
</html>
