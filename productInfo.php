<?php
$ids=$_GET["ids"];
$lists = explode('-', $ids);
$result = array();

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$redis_key = 'productInfo'.$ids;
$redis_result = $redis->get($redis_key);
if ($redis_result) {
	echo $redis_result;
}else{
	$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	foreach ($lists as $id){ 
		$args = array(
	    'productId' => $id,
	    'storeView' => 'china'
		);
		$res = $client->call($session, 'catalog_product.info', $args);
		
		array_push($result, $res);
	}
	$client->endSession($session);
	$redis->set($redis_key,json_encode($result));
	echo json_encode($result);
}

?>