<?php
include_once "db_interface/DatabaseClass.php";
$db = new Database();
extract($_POST);
session_start();

if(isset($_SESSION["USERID"])){
    die('<html><body>既にログインしています<br><a href="javascript:history.go(-1)">戻る</a>');
}

login($user,$pass);
  
function login($name,$pass){
    global $db;
    if(preg_match('/[][}{)(!"#$%&\'~|\*+,\/@.\^<>`;:?_=\\\\-]/i',$name)){
        die('<html><body>ユーザー名が不正です<br><a href="javascript:history.go(-1)">戻る</a>');
    }
    $query = "select pass from user where login_name=?";
    $db->prepare($query);
    $db->bind_param('s',$name);
    $result=$db->execute();
    if($result->num_rows == 0){
        echo "hoge";
        die('<html><body>ユーザー名もしくはパスワードが合いません<br><a href="javascript:history.go(-1)">戻る</a>');
    }
    //$pass=hash('sha256',$pass);
    $result->bind_result($dbpass);
    $result->fetch();
    if(!($pass===$dbpass)){
        die('<html><body>ユーザー名もしくはパスワードが合いません<br><a href="javascript:history.go(-1)">戻る</a>');
    }else{
        session_regenerate_id(TRUE);
        $_SESSION["USERID"]=$name;
        header("Location:index.php");
    }
}

?>
