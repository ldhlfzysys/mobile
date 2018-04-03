<?php
	include_once('./aliyun-log-php-sdk/sample/sample.php');

	$contents = array(
		"test" => "test",
		"userid" => "34"
	);
	$res = addLog($contents);

	echo json_encode($res);

	// echo "test";	
?>