<?php
        session_start();
        if(!isset($_SESSION["USERID"])){
                header("Location:login.html");
        }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>アップロード！</title>
</head>
<body>
<form action="file_upload.php" method="post" enctype="multipart/form-data">
  ファイル：<br />
  <input type="file" name="file" size="30" /><br />
  <br />
  <input type="submit" value="アップロード" />
</form>
</body>
</html>
