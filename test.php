<?php

$cartid=$_GET['c'];
$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

$result = $client->call($session,'cart_payment.list',$cartid);

echo json_encode($result);

$result2 = $client->call($session,'cart.info',$cartid);
echo json_encode($result2);
?>