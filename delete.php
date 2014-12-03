<?php
	session_start();
	if(!isset($_SESSION["USERID"])){
		header("Location:login.html");
	}
	include_once "db_interface/DatabaseClass.php";
	$db=new Database();
	$uid=$db->getuid($_SESSION["USERID"]);
	$server_filename="";
?>
