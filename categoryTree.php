<?php

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');


$result = $client->call($session, 'catalog_category.tree');

// var_dump($result);
// print_r($result);
echo json_encode($result);

// If you don't need the session anymore
//$client->endSession($session);
?>