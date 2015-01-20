<?php
        session_start();
        if(!isset($_SESSION["USERID"])){
                header("Location:login.html");
        }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>タグリスト - QSSS</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="tag_list2.css">
</head>
<body>
<div id="wrapper">
<h1><a class="title" href="index.php">Question Sheet Share System</a></h1>
<?php if($_SESSION["MANAGERID"]==1): ?>
<?php echo $_SESSION["SHOWNAME"] ?>（管理者）でログインしています<br>
<?php else: ?>
<?php echo $_SESSION["SHOWNAME"] ?>でログインしています<br>
<?php endif; ?>
<div id=menu2>
<ul id="menu">
<li><a href="upload.php">ファイルアップロード</a></li>
<li><a href="tag_list.php">タグリスト</a></li>
<li><a href="modify-user/">パスワード変更</a></li>
<li><a href="delete_user.php">ユーザ削除</a></li>
<li><a href="logout.php">ログアウト</a></li>
</ul>
</div>
<br>
<br>
<div id="taglist">
<?php
  include "get_tags_list.php";
?>
</div>
</div>
</body>
</html>
