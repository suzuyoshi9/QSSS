<?php
include_once "db_interface/DatabaseClass.php";
$db = new Database();
extract($_POST);
$name = preg_replace('/(\s|　)/','',$name);
$query = "select name from tag where name=?";
$db->prepare($query);
$db->bind_param('s',$name);
$result=$db->execute();
$result->store_result();
if($result->num_rows != 0) die('<html><body>そのタグは既に存在します<br><a href="javascript:history.go(-1)">戻る</a></body></html>');
$result->close();

$query="insert into tag (name) values (?)";
$db->prepare($query);
$db->bind_param('s',$name);
$result=$db->execute();
if(!$result) die('<html><body>ユーザーの追加に失敗しました<br><a href="javascript:history.go(-1)">戻る</a></body></html>');

echo <<<EOM
<html>
<head>
</head>
<body onload="window.opener.execute(); window.open(location,'_self').close();">
</body>
</html>
EOM;
?>
