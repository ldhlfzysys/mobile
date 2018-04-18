<?php
// 域名地址
$baseHost = "https://m.bdbbuy.com/";
// $baseHost = "http://47.75.153.67/";

$redisHost = "127.0.0.1";
$redisPort = 6379;

// 阿里云地址方法
function smallImage($originPath){
	$imageName = basename($originPath);
	$imageNameFix = preg_replace("/_[\d]/", "", $imageName);
	return 'https://bdbbuy-mobile.oss-cn-hongkong.aliyuncs.com/'.$imageNameFix.'?x-oss-process=style/center';
}

function originImage($originPath){
	$imageName = basename($originPath);
	$imageNameFix = preg_replace("/_[\d]/", "", $imageName);
	return 'https://bdbbuy-mobile.oss-cn-hongkong.aliyuncs.com/'.$imageNameFix;
}


?>