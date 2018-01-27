<?php
ini_set('display_errors',1); 
ini_set('display_startup_errors',1);
function getOrderList($userid){

	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);

	$redis_key = 'OrderListAll';
	$redis_result = $redis->get($redis_key);
	$result;
	if ($redis_result) {
		$result = $redis_result;
	}else
	{
		$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
		$session = $client->login('mobile', 'mobile');
		$result = $client->call($session, 'order.list');
	}


	$myOrderList = array();
	foreach ($result as $key => $value) {
		if ($value['customer_id'] == $userid) {
			array_push($myOrderList, $value);
		}
	}
	return $myOrderList;
}

if (isset($_GET['userid'])) {
	$result = getOrderList($_GET['userid']);
	$json_result = json_encode($result);
	echo $json_result;
}else
{
	echo '<script type="text/javascript">';
	echo 'window.location.href="http://bdbbuy.com/mobile/login2.html";';
	echo '</script>';
}


?>