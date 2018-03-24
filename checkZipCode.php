<?php
ini_set('display_errors',1);
if (isset($_POST['zipcode'])) {
	$zipcode = $_POST['zipcode'];
    $client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
    $session = $client->login('mobile', 'mobile');
    $result = $client->call($session, 'cart_shipping.checkzipcode', $zipcode);
    echo $result;
}else{
	echo 0;
}

?>