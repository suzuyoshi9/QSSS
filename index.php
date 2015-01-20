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
<title>QSSS</title>
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
<table border=4 width=700 align=center>
<tr>
<th>ファイル名</th>
<th>作成日時</th>
<th>作成者</th>
<th>タグ</th>
</tr>
<?php
	include_once "db_interface/DatabaseClass.php";
        $db=new Database();
	$query = "select d.id,d.filename,d.gen_date,u.show_name from document d, user u where d.uid=u.id";
        $result=$db->query($query);
        $result->bind_result($did,$filename,$date,$show_name);
        while($result->fetch()){
           echo "<tr>\n";
	   echo "<th>";
	   echo '<a href="details.php?did=';
	   echo $did;
	   echo '">';
	   echo $filename."</th>\n";
	   echo "<th>".$date."</th>\n";
           echo "<th>".$show_name."</th>\n";
           $sql="select t.id,t.name from tag t, tagmap tm where tm.doc_id=? and t.id=tm.tag_id";
           $db->prepare($sql);
           $db->bind_param('i',$did);
           $result_tag = $db->execute();
           $result_tag->bind_result($tid,$t_name);
           echo "<th><ul>";
           while($result_tag->fetch()){
              echo "<li>";
              echo '<a href="tag_search.php?tid=';
              echo $tid;
              echo '">';
              echo $t_name."</li>";
           }
           echo "</ul></th>\n";

	   echo "</tr>\n";
        }
?>
</table>
</div>
</body>
</html>
