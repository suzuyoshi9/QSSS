<?php
        session_start();
        if(!isset($_SESSION["USERID"])){
                header("Location:login.html");
        }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>仮ホームページ</title>
</head>
<body>
<h1>QSSS</h1>
<a href="upload.php">ファイルアップロード</a><br>
<a href="login.php">ログイン</a><br>
<a href="logout.php">ログアウト</a><br>
<div align="center">
<?php
  include "get_tags_list.php";
?>
</div>
</body>
</html>
