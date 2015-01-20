
<?php
session_start();
$did= isset($_GET['did']) ? htmlspecialchars($_GET['did']) : null;
if($did==null){
	die("このファイルは存在しません。");
}
	if(!isset($_SESSION["USERID"])){
		header("Location:login.html");
	}
	
        include_once "db_interface/DatabaseClass.php";
        $db=new Database();
	$query="select filename,server_filename from document where id=".$_GET['did'];
	$result=$db->query($query);
	$result->bind_result($filename,$s_f);
	$result->fetch();
	if($s_f==null){
	die("このファイルは存在しません。");
}
	header('Content-Type:application/octet-stream');  //ダウンロードの指示
	header("Content-Disposition: attachment; filename=$filename");  //ダウンロードするファイル名
	header('Content-Length:'.filesize("files/".$s_f));   //ファイルサイズを指定
	header("Connection: close");
	ob_end_clean();
	readfile("files/".$s_f);  //ダウンロード
?>
