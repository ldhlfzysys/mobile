<?php

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');


$result = $client->call($session, 'catalog_product.list');

var_dump($result);

// If you don't need the session anymore
//$client->endSession($session);
?>