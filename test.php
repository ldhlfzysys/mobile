<?php

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

$arrProducts = array(
	array(
		"product_id" => "5972",
		"qty" => 2
	)
);

$result = $client->call($session, 'cart_product.add', array('431',$arrProducts,'16'));

// var_dump($result);
echo json_encode($result);

// If you don't need the session anymore
//$client->endSession($session);
?>