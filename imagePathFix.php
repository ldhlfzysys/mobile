<?php

function smallImage($originPath){
	$imageName = basename($originPath);
	$imageNameFix = preg_replace("/_[\d]/", "", $imageName);
	return 'http://bdbbuy-mobile.oss-cn-hongkong.aliyuncs.com/'.$imageNameFix.'?x-oss-process=style/center';
}

function originImage($originPath){
	$imageName = basename($originPath);
	$imageNameFix = preg_replace("/_[\d]/", "", $imageName);
	return 'http://bdbbuy-mobile.oss-cn-hongkong.aliyuncs.com/'.$imageNameFix;
}


?>