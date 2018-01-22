<?php
ini_set('display_errors',1); 
ini_set('display_startup_errors',1);

$searchword=$_GET['s'];

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

$result = $client->call($session, 'catalog_product_attribute_tier_price.info', $searchword);
var_dump($result);


?>