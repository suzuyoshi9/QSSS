
<?php
session_start();
	if(!isset($_SESSION["USERID"])){
		header("Location:login.html");
	}
function loadFile($server_filename, $filename = '')
{
    // DBにファイルがあるかどうかチェックしたい
    if (! file_exists($server_filename)) {
        exit;
    }
    // 読込みできるかチェックしたい
    if (! is_readable($server_filename)) {
        exit;
    }

    // ファイル情報を取得したい
    $path_parts = pathinfo($server_filename);

    // 拡張子を小文字置換したい？
    $file_ext = strtolower($path_parts['extension']);

    // 拡張子によるContent-TypeとContent-Dispositionの設定
    if ($file_ext == 'pdf') {
        $content_type = 'application/pdf';
    } elseif ($file_ext == 'gif') {
        $content_type = 'image/gif';
    } elseif ($file_ext == 'jpg' || $file_ext == 'jpeg') {
        $content_type = 'image/jpeg';
    } elseif ($file_ext == 'png') {
        $content_type = 'image/png';
    } else {
        $content_type = 'application/octet-stream';
    }

    if (preg_match('/\(gif|jpe?g|png)$/', $file_ext)) {
        // inline ブラウザに表示したい
        $content_disposition = 'inline';
    } else {
        // attachment ダウンロード
        $content_disposition = 'attachment';
    }

    // ロードするファイル名が未定義の場合は元ファイル名と同じにしたい
    if (empty($filename)) {
        $filename = $path_parts['filename'];
    }

    // ヘッダ
    header('Cache-Control: public');
    header('Pragma: public');
    header('Content-Type: ' . $content_type);
    header('Content-Disposition: ' . $content_disposition . '; filename=' . $filename);
    // ファイル読込
    // 20M以下
    if (filesize($server_filename) < 20971520) {    
        readfile($server_filename);
    } else {
        // ファイルサイズが大きくreadfileでうまくいかない場合
        // （主に画像以外のファイル、20M程度が分岐目安）
        $fp = fopen($server_filename, 'rb');
        $contents = '';
        while (! feof($fp)) {
            $contents .= fgets($fp, 8192);
        }
        fclose($fp);
        echo $contents;
    }
    exit;
}
/*
$filename = $_GET['file'];

// required for IE, otherwise Content-disposition is ignored
if(ini_get('zlib.output_compression'))
  ini_set('zlib.output_compression', 'Off');

// addition by Jorg Weske
$file_extension = strtolower(substr(strrchr($filename,"."),1));

if( $filename == "" ) 
{
  echo "<html><title>eLouai's Download Script</title><body>ERROR: download file NOT SPECIFIED. USE force-download.php?file=filepath</body></html>";
  exit;
} elseif ( ! file_exists( $filename ) ) 
{
  echo "<html><title>eLouai's Download Script</title><body>ERROR: File not found. USE force-download.php?file=filepath</body></html>";
  exit;
};
switch( $file_extension )
{
  case "pdf": $ctype="application/pdf"; break;
  case "exe": $ctype="application/octet-stream"; break;
  case "zip": $ctype="application/zip"; break;
  case "doc": $ctype="application/msword"; break;
  case "xls": $ctype="application/vnd.ms-excel"; break;
  case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
  case "gif": $ctype="image/gif"; break;
  case "png": $ctype="image/png"; break;
  case "jpeg":
  case "jpg": $ctype="image/jpg"; break;
  default: $ctype="application/force-download";
}
header("Pragma: public"); // required
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); // required for certain browsers 
header("Content-Type: $ctype");
// change, added quotes to allow spaces in filenames, by Rajkumar Singh
header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filename));
readfile("$filename");
exit();
*/
?>
