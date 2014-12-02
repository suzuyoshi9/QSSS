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
<table border=3 width=500 align=center>
<tr>
<th>ファイル名</th>
<th>作成日時</th>
<th>作成者</th>
</tr>
<?php
	include_once "db_interface/DatabaseClass.php";
        $db=new Database();
	$query = "select d.filename,d.gen_date,u.show_name from document d, user u where d.uid=u.id";
        $result=$db->query($query);
        $result->bind_result($filename,$date,$show_name);
        while($result->fetch()){
           echo "<tr>";
	   echo "<th>".$filename."</th>";
	   echo "<th>".$date."</th>";
           echo "<th>".$show_name."</th>";
	   echo "</tr>";
        }
?>
</table>
</body>
</html>
