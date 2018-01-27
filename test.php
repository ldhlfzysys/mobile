<?php

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

$shipping_list = $client->call($session,'cart_shipping.list','611');

var_dump($shipping_list);
?>