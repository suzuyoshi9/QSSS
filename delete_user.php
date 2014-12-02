<?php
        session_start();
        if(!isset($_SESSION["USERID"])){
                header("Location:login.html");
        }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="delete.css" type="text/css">
<title>ユーザ削除</title>
</head>
<body>
<form action="delete-user.php" method="post">
  <p class="delete"><?php echo $_SESSION["USERID"] ?>を削除します。良ければ、パスワードを入力してください。</p>
  <input type="text" name="pass" size="30" />
  <input type="submit" value="送信" />
</form>
</body>
</html>
