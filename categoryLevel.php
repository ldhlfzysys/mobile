<?php

$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');


$result = $client->call($session, 'catalog_category.level');

var_dump($result);

// If you don't need the session anymore
//$client->endSession($session);
?>