<?php

$searchword=$_GET['s'];

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

$complexFilter = array(
            'name' => array('like' => '%'.$searchword.'%')
);

$args = array(
	'filters' => $complexFilter,
	'storeView' => '16'
);

$result = $client->call($session,'catalog_product.list',$args);

echo json_encode($result);



?>