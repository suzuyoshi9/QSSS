<?php
include_once "db_interface/DatabaseClass.php";
$db = new Database();
extract($_POST);
 
$query = "select login_name from user where login_name=?";
$db->prepare($query);
$db->bind_param('s',$user);
$result=$db->execute();
$result->store_result();
if($result->num_rows != 0) die('<html><body>そのユーザーは既に存在します<br><a href="javascript:history.go(-1)">戻る</a></body></html>');
if($pass!=$repass) die('<html><body>パスワードが合いません<br><a href="javascript:history.go(-1)">戻る</a></body></html>');
$result->close();
$pass=hash('sha256',$pass);
$query="insert into user (login_name,show_name,pass,mail,manager_id) values (?,?,?,?,?)";
$db->prepare($query);
$db->bind_param('ssssi',$user,$show_name,$pass,$mail,2);
$result=$db->execute();
if(!$result) die("ユーザーの追加に失敗しました");
echo '<html><body>ユーザーの追加に成功しました<br><a href="login.html">戻る</a></body></html>';
?>
