<?php
        session_start();
        if(!isset($_SESSION["USERID"])){
                header("Location:login.html");
        }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css">
<title>ファイルの詳細 - QSSS</title>
<script type="text/javascript" src="check.js"></script>
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
<table border=3 width=1000 align=center>
<tr>
<th>ファイル名</th>
<th>作成日時</th>
<th>ファイル形式</th>
<th>作成者</th>
<th>コメント</th>
<th>サイズ</th>
<th>プレビュー</th>
<th>ダウンロード</th>
<th>削除</th>

<?php
include_once "db_interface/DatabaseClass.php";
$did= isset($_GET['did']) ? htmlspecialchars($_GET['did']) : null;
if($did==null){
	die("このファイルは存在しません。");
}
$db = new Database();
$query = "select d.id,d.filename,d.server_filename,d.gen_date,d.comment,u.show_name from document d, user u where d.uid=u.id and d.id=".$did;
$result=$db->query($query);
$result->bind_result($did,$filename,$server_filename,$date,$comment,$show_name);
$result->fetch();
if($result->num_rows==0){
	die("このファイルは存在しません。");
}
echo "<tr>\n";
echo "<th>".$filename."</th>\n";
echo "<th>".$date."</th>\n";
echo "<th>".check_type($server_filename)."</th>\n";
echo "<th>".$show_name."</th>\n";
echo "<th>".$comment."</th>\n";
echo "<th>".byteConvert(filesize("./files/".$server_filename))."</th>\n";
echo "<th>";
$address = 'http://vps.suzuyoshi-net.com/qsss/pa_thumbnail.php?did='.$did;
$headers = get_headers( $address,1 );
if($headers['Content-Type'] == 'image/jpeg'){
	echo '<img src="pa_thumbnail.php?did=';
	echo $did;
	echo '" />';
}
echo "</th>\n";
echo "<th>";
echo '<a href="file_download.php?did=';
echo $did;
echo '">ダウンロード</a></th>';
echo "\n";
//削除？
echo '<th>';
echo "\n";
echo '<form method="POST" action="delete.php" onSubmit="return check()">';
echo "\n";
echo '<input type=hidden name="disposal" value="document">';
echo "\n";
echo '<input type=hidden name="did" value=';
echo $did;
echo ">\n";
if($db->getauthor($did)==$db->getuid($_SESSION["USERID"]) or $db->isadmin($_SESSION["USERID"])) echo '<input type=submit value="削除"></form></th>';
else echo '<input type=submit value="削除できません" disabled></form></th>';
echo "</tr>\n";

function byteConvert($bytes){
	$s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
	$e = floor(log($bytes)/log(1024));
	return sprintf('%.1f '.$s[$e], ($bytes/pow(1024, floor($e))));
}

function check_type($file){
	$finfo    = finfo_open(FILEINFO_MIME_TYPE);
	$mimeType = finfo_file($finfo,"./files/".$file);
	finfo_close($finfo);
	return $mimeType;
}

?>
</table>
</div>
</body>
</html>
