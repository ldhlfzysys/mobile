<?php

	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$args = array(
	    'store' => '16'
		);
	$result = $client->call($session, 'cart_coupon.remove',array('1763'));
	echo $result;

?>