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
<table border=3 width=500 align=center>
<tr>
<th>ファイル名</th>
<th>作成日時</th>
<th>作成者</th>
<th>ダウンロード</th>

<?php
include_once "db_interface/DatabaseClass.php";
$did= isset($_GET['did']) ? htmlspecialchars($_GET['did']) : null;
$db = new Database();
$query = "select d.id,d.filename,d.gen_date,u.show_name from document d, user u where d.uid=u.id and d.id=".$did;
$result=$db->query($query);
$result->bind_result($did,$filename,$date,$show_name);
$result->fetch();
echo "<tr>";
echo "<th>".$filename."</th>";
echo "<th>".$date."</th>";
echo "<th>".$show_name."</th>";
echo "<th>";
echo '<a href="file_download.php?did=';
echo $did;
echo '">ダウンロード</a></th>';
//削除？
echo "</tr>";
?>
</table>
</body>
</html>
