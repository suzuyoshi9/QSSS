<?php
session_start();
include_once "../db_interface/DatabaseClass.php";

$db = new Database();
extract($_POST);
$user=$_SESSION["USERID"];
$current_pass=hash('sha256',$current_pass);
$query = "select pass from user where login_name=?";
$db->prepare($query);
$db->bind_param('s',$user);
$result=$db->execute();
$result->bind_result($dbpass);
$result->fetch();
if($current_pass!=$dbpass) die('<html><body>パスワードが合いません<br><a href="javascript:history.go(-1)">戻る</a></body></html>');
if($pass!=$repass) die('<html><body>aパスワードが合いません<br><a href="javascript:history.go(-1)">戻る</a></body></html>');
$pass=hash('sha256',$pass);
$query="update user set pass=? where login_name=?";
$db->prepare($query);
$db->bind_param('ss',$pass,$user);
$result=$db->execute();
if(!$result) die("パスワードの変更に失敗しました");
else echo '<html><body>パスワードの変更に成功しました<br><a href="../index.php">戻る</a></body></html>';
?>
