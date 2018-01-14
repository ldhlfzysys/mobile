<?php
ini_set('display_errors',1); 
ini_set('display_startup_errors',1);
function getOrderList($userid){
	$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$args = array(
	    'customer_id' => $userid
		);
	$result = $client->call($session, 'order.list', $args);
	return $result;
}

$result1 = getOrderList('7');
echo $result1;

?>