<?php

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

$filters = array(
    'filters' => array(
        'status' => 1, 
        'type_id' => 'simple',
    ),
    'storeView' => 'china'
);

$result = $client->call($session, 'catalog_product.list',$filters);

// var_dump($result);
echo json_encode($result);

// If you don't need the session anymore
//$client->endSession($session);
?>