<?php

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

$id=$_GET["id"];
$result = $client->call($session, 'catalog_product_attribute_media.list', $id);
echo json_encode($result);

// If you don't need the session anymore
//$client->endSession($session);
?>