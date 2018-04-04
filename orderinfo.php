<?php
ini_set('display_errors',1); 
ini_set('display_startup_errors',1);
function getOrderInfo($orderid){

	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);

	$redis_key = 'order_'.$orderid;
	$redis_result = $redis->get($redis_key);
	$result;
	if ($redis_result) {
		$result = $redis_result;
	}else
	{
		$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
		$session = $client->login('mobile', 'mobile');
		$result = $client->call($session, 'sales_order.info',$orderid);
	}

	return $result;
}

if (isset($_GET['orderid'])) {
	$result = getOrderInfo($_GET['orderid']);
	$json_result = json_encode($result);
	echo $json_result;
}else{
	// echo '<script type="text/javascript">';
	// echo 'window.location.href="https://m.bdbbuy.com/login.html";';
	// echo '</script>';
}


?>