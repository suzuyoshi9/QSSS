<?php
	session_start();
	if(!isset($_SESSION["USERID"])){
		header("Location:login.html");
	}
	
	include_once "db_interface/DatabaseClass.php";
	$db=new Database();
	print_r $_SESSION;
	$uid=$db->getuid($_SESSION["USERID"]);
	print "b";
	print $_SESSION["USERID"];
	$rand_str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	for($i=0; $i<15; $i++){
		$server_filename .= mt_rand(0, strlen($str)-1);
	}//たぶん文字列ランダム

	date_default_timezone_set('Asia/Tokyo');
	ini_set( 'display_errors', 1 ); 
	
	if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
		if(move_uploaded_file($_FILES["file"]["tmp_name"],"files/" . $server_filename)){
			//chmod("files/" . $_FILES["file"]["name"],0644);
			print "アップロード完了<br />";
			$file_name=$_FILES["file"]["tmp_name"];
		}else{
		die("アップロードerror<br />");
		}

	}else{
		die("ファイル<br />");
	}	
	
	
	//実ファイル名 $file_name
	//サーバ上でのファイル名 $server_filename
	//作成日時  sql上でnow
	//ユーザID $uid
	
	$query = "insert into document(filename,server_filename,gen_data,uid) values (?,?,?,?)";
	$db->prepare($query);
	$db->bind_param('sssi',$filename,$server_filename,"now()",$uid);
	$result=$db->execute();
	if($result){
		echo '<html><body>ファイルアップロードが完了しました<br><a href="index.php">戻る</a></body></html>';
	}else{
		echo "失敗だぼけぇ！";
	}
?>
