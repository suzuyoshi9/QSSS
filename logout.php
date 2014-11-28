<?php
//参考 http://d.hatena.ne.jp/replication/20100828/1282994791
session_start();

if (isset($_SESSION["USERID"])) {
    $errorMessage = "ログアウトしました。";
}
else {
    $errorMessage = "セッションがタイムアウトしました。";
}
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
?>

<!DOCTYPE html>
<html>
  <head>
    <title>ログアウト</title>
  </head>
  <body>
  <div><?php echo $errorMessage; ?></div>
  <a href="login.html">戻る</a>
  </body>
</html>
