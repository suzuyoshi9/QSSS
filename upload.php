<?php
        session_start();
        if(!isset($_SESSION["USERID"])){
                header("Location:login.html");
        }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="tag_list.css">
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript">
function execute() {
	var a = new Ajax.Updater(
		"tag_list",
		"get_tags.php",
		{
			"method": "get",
			onSuccess: function(request) {
				// 成功時の処理を記述
				// alert('成功しました');
				// jsonの値を処理する場合↓↓
				//  var json;
				//  eval("json="+request.responseText);
			},
			onComplete: function(request) {
				// 完了時の処理を記述
				// alert('読み込みが完了しました');
				// jsonの値を処理する場合↓↓
				//  var json;
				//  eval("json="+request.responseText);
			},
			onFailure: function(request) {
				alert('読み込みに失敗しました');
			},
			onException: function (request) {
				alert('読み込み中にエラーが発生しました');
			}
		}
	);
}
</script>
<title>ファイルアップロード - QSSS</title>
</head>
<body onload="execute()">
<div id = "wrapper">
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
<p>
<h2>アップロードの条件</h2>
ファイルのアップロード上限は50MBです。<br>
ファイルの種類（拡張子）は .jpg .png .pdf .docx .doc .xls .xlsx .ppt .pptx のみアップロードできます。
</p>
<form action="file_upload.php" method="post" enctype="multipart/form-data">
ファイル：<br />
<input type="file" name="file" size="30" accept=".jpg,.png,.pdf,.docx,.doc,.xls,.xlsx,.ppt,.pptx" required><br />
<br />
コメント：<br />
<textarea name="comment" cols="50" rows="5"></textarea><br /><br />
タグ：<br />
<div id="tag_list">
</div>
<br />
<a href="tag_add.html" onClick="window.open('tag_add.html','subwin','width=300,height=300'); return false;"> タグ追加はこちら</a><br /><br />
<input type="submit" value="アップロード" />
</form>
</div>
</body>
</html>
