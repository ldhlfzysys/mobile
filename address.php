<?php

function customer_address($userid){
	$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	// $result = $client->call($session, 'customer.list');
	$result = $client->call($session, 'customer_address.list', $userid);
	return $result;
}

function customer_address_create($userid,$firstname,$lastname,$street,$city,$postcode,$tele,$isDefaultBilling,$isDefaultShipping){
	$address_data = array(
		'customerId' => $userid, 
		'addressdata' => 
		array(
			'firstname' => $firstname, 
			'lastname' => $lastname, 
			'street' => array($street), 
			'city' => $city, 
			'country_id' => 'CA', 
			'region' => 'Ontario', 
			'region_id' => 74, 
			'postcode' => $postcode, 
			'telephone' => $tele, 
			'is_default_billing' => $isDefaultBilling, 
			'is_default_shipping' => $isDefaultShipping
			)
	);
	$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	// $result = $client->call($session, 'customer.list');
	$result = $client->call($session, 'customer_address.create', $address_data);
	return $result;
}

// var_dump(customer_address('29')); 
var_dump(customer_address_create('29','vvvv','vvvvv','asdfasdf','wuping','123','1854444',false,true));

?>