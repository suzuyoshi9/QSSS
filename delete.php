<?php
	session_start();
	if(!isset($_SESSION["USERID"])){
		header("Location:login.html");
	}
	include_once "db_interface/DatabaseClass.php";
	extract($_POST);
	$db=new Database();
	$uid=$db->getuid($_SESSION["USERID"]);
        if($disposal==="user") user($uid,$_POST["pass"]);
	else if($disposal==="document") document($did);
	else if($disposal==="tag") user($tid);
	
	function user($uid,$pass){
		global $db;
    		$query = "select pass from user where id=?";
    		$db->prepare($query);
    		$db->bind_param('i',$uid);
    		$result=$db->execute();
    		if($result->num_rows == 0){
        		die('<html><body>ユーザー名もしくはパスワードが合いません<br><a href="javascript:history.go(-1)">戻る</a>');
    		}
    		$pass=hash('sha256',$pass);
    		$result->bind_result($dbpass);
    		$result->fetch();
    		if($pass!=$dbpass){
        		die('<html><body>ユーザー名もしくはパスワードが合いません<br><a href="javascript:history.go(-1)">戻る</a>');
		}else{
			$dids = array();
			$query = "select id from document where uid = ?";
			$db->prepare($query);
			$db->bind_param('i',$uid);
			$result=$db->execute();
			$result->bind_result($tmp);
			while($result->fetch()) array_push($dids,$tmp);
			foreach($dids as $did) document($did);
			$query = "delete from user where id = ?";
			$db->prepare($query);
			$db->bind_param('i',$uid);
			$result=$db->execute();
			if(!$result) die("<html><body>ユーザの削除に失敗しました。<br><a href=index.php>トップに戻る</a></body></html>");
			echo "<html><body>ユーザの削除に成功しました。<br><a href=index.php>トップに戻る</a></body></html>";
			// セッション変数のクリア
			$_SESSION = array();
			// クッキーの破棄
		 	if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();
        			setcookie(session_name(), '', time() - 42000,
        				$params["path"], $params["domain"],
        				$params["secure"], $params["httponly"]
        			);
			}
			// セッションクリア
			session_destroy();
		}
	}
	
	function document($did){
		global $db;
                if($db->getauthor($did)!=$db->getuid($_SESSION["USERID"]) and !$db->isadmin($_SESSION["USERID"])) die('<html><body>作成者以外は削除することができません<br><a href="javascript:history.go(-1)">戻る</a></body></html>');
		$query = "select filename, server_filename from document where id = ?";
		$db->prepare($query);
		$db->bind_param('i',$did);
		$result=$db->execute();
		$result->bind_result($filename,$server_filename);
		$result->fetch();
		unlink("files/$server_filename");
		$query = "delete from document where id = ?";
		$db->prepare($query);
		$db->bind_param('i',$did);
		$result=$db->execute();
		if(!$result){
                        echo $filename."の削除に失敗しました。<br><a href=index.php>トップに戻る</a></body></html>";
                        return;
                }
                if(showCallerFunc()=="user") return;
		echo $filename."の削除に成功しました。<br><a href=index.php>トップに戻る</a></body></html>";
	}
	
	function tag($tid){
	}

        function showCallerFunc() {
                $dbg = debug_backtrace();
                echo( $dbg[1]['function'] );
        }
?>
