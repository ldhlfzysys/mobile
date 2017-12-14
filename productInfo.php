<?php

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

$ids=$_GET["ids"];
$lists = explode('-', $ids);
$result = array();
foreach ($lists as $id){ 
	// print_r($sku);
	// $sku = '6629452600183';
	$res = $client->call($session, 'catalog_product.info', $id);
	array_push($result, $res);
	// array_push($result, $client->call($session, 'catalog_product.info', $sku));
}
// $result = $client->call($session, 'catalog_product.info', '5006');

// var_dump($result);
echo json_encode($result);

// If you don't need the session anymore
//$client->endSession($session);
?>