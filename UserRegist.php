<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>
<body>
    <h2>ユーザー登録</h2>
    <form method="POST" action="Register.php">
        <p>
            ユーザーID 登録（20字以内）<br />
            <input type="text" name="id" size="20" maxlength="20" />
        </p><p>
            パスワード（20字以内）<br />
            <input type="text" name="pwd" size="20" maxlength="20" />
        </p><p>
            <input type="submit" value="登録" />
        </p>
    </form>
</body>
</html>