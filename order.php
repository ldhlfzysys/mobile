<?php 
ini_set('display_errors',1); 
function addconpon($cartid,$coupon){

	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$result = $client->call($session, 'cart_coupon.add',array(intval($cartid),strval($coupon)));
	return json_encode($result);
}

function removeconpon($cartid){
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$result = $client->call($session, 'cart_coupon.remove',$cartid);
	return json_encode($result);
}

if (isset($_POST['cartid']) && isset($_POST['coupon'])) {
	$cartId = $_POST['cartid'];
	$coupon = $_POST['coupon'];
	$result = addconpon($cartId,$coupon);
	echo $result;
}

if (isset($_POST['cartid']) && isset($_POST['remove'])) {
	$cartId = $_POST['cartid'];
	$result = removeconpon($cartId);
	echo $result;
}

function set_cart_user($cartid,$userinfo,$mode)
{
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$customerAsGuest = array(
		"firstname" => $userinfo['firstname'],
		"lastname" => $userinfo['lastname'],
		"email" => $userinfo['email'],
		"website_id" => "base",
		"store_id" => "china",
		"mode" => $mode
	);
	if ($mode == "customer") {
		$customerAsGuest['customer_id'] = $userinfo['customer_id'];
	}
	$result = $client->call($session,'cart_customer.set',array($cartid,$customerAsGuest));
	return $result;
}

function set_shipping($cartid){
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$shipping_list = $client->call($session,'cart_shipping.list',$cartid);
	$cheap = null;
	foreach ($shipping_list as $shippingMethod) {
		if ($cheap == null) {
			$cheap = $shippingMethod;

		}
		if (floatval($shippingMethod['price']) < floatval($cheap['price'])) {
			$cheap = $shippingMethod;
		}
	}
	$result = $client->call($session,'cart_shipping.method',array($cartid,$cheap['code']));

	return $result;
}

function set_payment($cartid)
{
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$paymentMethod = array(
		"method" => "cashondelivery"
	);
	try{
		$result = $client->call($session,'cart_payment.method',array($cartid,$paymentMethod));	
		return $result;
	}catch(SoapFault $e)
	{
		return null;
	}
}

#用于没有地址的用户
function set_cart_address($cartid,$billingAddress,$shippingAddress)
{
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$arrAddresses = array(
		array(
			"mode" => "billing",
			"firstname" => $billingAddress['firstname'],
			"lastname" => $billingAddress['lastname'],
			"company" => "",
			"street" => $billingAddress['street'],
			"city" => $billingAddress['city'],
			"postcode" => $billingAddress['postcode'],
			"country_id" => "CA",
			"region_id" => "74",
			"telephone" => $billingAddress['telephone'],
			"fax" => "",
			"is_default_shipping" => 0,
			"is_default_billing" => 1
		),
		array(
			"mode" => "shipping",
			"firstname" => $shippingAddress['firstname'],
			"lastname" => $shippingAddress['lastname'],
			"company" => "",
			"street" => $shippingAddress['street'],
			"city" => $shippingAddress['city'],
			"postcode" => $shippingAddress['postcode'],
			"country_id" => "CA",
			"region_id" => "74",
			"telephone" => $shippingAddress['telephone'],
			"fax" => "",
			"is_default_shipping" => 1,
			"is_default_billing" => 0
		)
	);
	$result = $client->call($session,'cart_customer.addresses',array($cartid,$arrAddresses));
	return $result;
}




?>