<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', '1');

//色々いじったからなんかサムネイルが生成されてないと表示されなくなった？

//
// +----------------------------------------------------------------------+
//pa_thumbnail
// +----------------------------------------------------------------------+
//@package pa_thumbnailV.2(beta) 2012/11/12
//@author Studio PhotoArtisan
//@copyright 2012 Studio PhotoArtisan
//
include_once "db_interface/DatabaseClass.php";
$did= isset($_GET['did']) ? htmlspecialchars($_GET['did']) : null;
$db = new Database();
$query = "select id,filename,server_filename from document where id=".$did;
$result=$db->query($query);
$result->bind_result($id,$filename,$server_filename);
$result->fetch();

$foldername = 'thumbnails/';//キャッシュファイル保存先フォルダ名
$SaveImage = TRUE;//キャッシュファイルを保存しない場合はFALSEに変更
$MaxImageSize = 600;//サムネイル画像の最大サイズ
$quality = 70;//jpg画質

$folder = dirname(__FILE__)."/".$foldername;
$src = dirname(__FILE__)."/files/".$server_filename;
$size = 200;
$filename = $did.'_'.$size;//ファイル名設定
$path = $folder . $filename;
if (!file_exists($folder)) {//キャッシュフォルダの存在チェック
	mkdir($folder, 0777);//キャッシュフォルダを作成
}

if ($size > $MaxImageSize) {
	$size = $MaxImageSize;//最大画像サイズに固定
}

$image = new Imagick();

if (file_exists($path)) {//cache=noを渡すとキャッシュファイルを読み込みません
	$image -> readImage($path);//キャッシュファイルを読み込み
	header('Content-type: image/jpeg');
	echo $image;//イメージ出力
} else {//キャッシュファイルが無いまたは読み込まない場合
	//$image -> readImage($src);//元ファイルを読み込み

	//try{
		$image -> readImage($src);
	//}catch(ImagickException $e){
	//	die;
	//}

	$image -> setImageOpacity(1.0);//透過画像対策
	$image -> flattenImages();//レイヤー対策
	$image -> thumbnailImage($size, $size, true);//サイズ変更
	$image -> setImageFormat('jpg');//jpgに変換
	$image ->setImageCompression(Imagick::COMPRESSION_JPEG); //圧縮方式を指定
	$image -> setImageCompressionQuality($quality);//画質を設定(PHP5.1.6以降？)
	$cs = $image -> getImageColorspace();//カラースペースを取得
	if ($SaveImage == TRUE or $cs == Imagick::COLORSPACE_CMYK) {
		$image -> writeImage($path);//キャッシュファイルを作成
	}
	if ($cs == Imagick::COLORSPACE_CMYK)//CMYKの場合
	{
		$gdimage = ImageCreateFromJPEG($path);//GDで読み込み
		unlink($path);//キャッシュファイルを削除
		ImageJPEG($gdimage);//GDで表示(GD内で自動的にRGBに変換)
		if ($SaveImage == TRUE) {
			ImageJPEG($gdimage, $path, $quality);//キャッシュを保存
		}
		imagedestroy($gdimage);//メモリ開放
	}
	//CMYK以外
	else{
		header('Content-type: image/jpeg');
		echo $image;//イメージ出力
	}
}
imagick_destroyhandle($image);//メモリ開放
?>
