<?php

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$redis_key = 'productlistall';
$redis_result = $redis->get($redis_key);

if ($redis_result) {
	echo $redis_result;
}else{
	$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$result = $client->call($session, 'catalog_product.list');
	$client->endSession($session);
	$json_result = json_encode($result);
	$redis->set($redis_key,$json_result);
	echo $json_result;
}


?>