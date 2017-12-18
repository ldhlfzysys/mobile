<?php

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

$result = $client->call($session, 'catalog_product.currentStore', 'china');

$args = array(
    'productId' => '5974',
    'storeView' => 'china'
);

$sku = '5974';
$res = $client->call($session, 'catalog_product.info',$args);

echo json_encode($res);

?>