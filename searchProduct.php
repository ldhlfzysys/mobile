<?php
// $ids=$_GET["ids"];
$word = '面包';
$lists = explode('-', $ids);
$result = array();

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
$session = $client->login('mobile', 'mobile');
foreach ($lists as $id){ 
	$args = array(
    'filters' => $word,
    'storeView' => 'china'
	);
	$res = $client->call($session, 'catalog_product.list', $args);
	
	array_push($result, $res);
}
$client->endSession($session);
echo json_encode($result);
?>