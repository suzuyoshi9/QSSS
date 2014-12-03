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
<title>アップロード！</title>
</head>
<body onload="execute()">
<h1>ファイルのアップロード上限は50MBです!!!!!!!!!</h1>
<form action="file_upload.php" method="post" enctype="multipart/form-data">
ファイル：<br />
<input type="file" name="file" size="30" required><br />
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
</body>
</html>
