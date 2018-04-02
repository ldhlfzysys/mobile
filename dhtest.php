<?php
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');

		$args = array(
	    'productId' => '5941',
	    'storeView' => 'china'
		);
		$res = $client->call($session, 'catalog_product.info', $args);
	$client->endSession($session);
	echo json_encode($res);
?>