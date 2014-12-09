<?php
        session_start();
        if(!isset($_SESSION["USERID"])){
                header("Location:login.html");
        }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ファイルの詳細-仮ホームページ</title>
</head>
<body>
<h1>QSSS</h1>
<a href="upload.php">ファイルアップロード</a><br>
<a href="login.php">ログイン</a><br>
<a href="logout.php">ログアウト</a><br>
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

<?php
include_once "db_interface/DatabaseClass.php";
$did= isset($_GET['did']) ? htmlspecialchars($_GET['did']) : null;
$db = new Database();
$query = "select d.id,d.filename,d.server_filename,d.gen_date,d.comment,u.show_name from document d, user u where d.uid=u.id and d.id=".$did;
$result=$db->query($query);
$result->bind_result($did,$filename,$server_filename,$date,$comment,$show_name);
$result->fetch();

echo "<tr>";
echo "<th>".$filename."</th>";
echo "<th>".$date."</th>";
echo "<th>".check_type($server_filename)."</th>";
echo "<th>".$show_name."</th>";
echo "<th>".$comment."</th>";
echo "<th>".byteConvert(filesize("./files/".$server_filename))."</th>";
echo "<th>"."</th>";
echo "<th>";
echo '<a href="file_download.php?did=';
echo $did;
echo '">ダウンロード</a></th>';
//削除？
echo "</tr>";

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
</body>
</html>
