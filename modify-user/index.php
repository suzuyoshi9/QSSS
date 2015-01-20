<!DOCTYPE HTML>
<?php
	session_start();
	if(!isset($_SESSION["USERID"])){
		header("Location:login.html");
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../style.css">
<title>パスワード変更 - QSSS</title>
</head>
<body>
<div id="wrapper">
<h1><a class="title" href="http://vps.suzuyoshi-net.com/qsss/index.php">Question Sheet Share System</a></h1>
<?php if($_SESSION["MANAGERID"]==1): ?>
<?php echo $_SESSION["SHOWNAME"] ?>（管理者）でログインしています<br>
<?php else: ?>
<?php echo $_SESSION["SHOWNAME"] ?>でログインしています<br>
<?php endif; ?>
<div id=menu2>
<ul id="menu">
<li><a href="../upload.php">ファイルアップロード</a></li>
<li><a href="../tag_list.php">タグリスト</a></li>
<li><a href="../modify-user/">パスワード変更</a></li>
<li><a href="../delete_user.php">ユーザ削除</a></li>
<li><a href="../logout.php">ログアウト</a></li>
</ul>
</div>
<br>
<br>

<p>パスワードを変更できます</p>
<form action="pass_change.php" method="POST">
<p>現在のパスワード:<input type="password" name="current_pass" size="10" required></p>
<p>新パスワード:<input type="password" name="pass" size="10" required></p>
<p>新パスワード(再入力):<input type="password" name="repass" size="10" required></p>
<p><input type="submit" value="送信"></p>
</form>

</div>

</body>
</html>

