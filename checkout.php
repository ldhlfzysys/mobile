<?php

//注意：目前网站货到付款关闭了，因此在设置付款方式时会报错。我的计划是，网站打开货到付款，但是pc不显示，mobile端默认就用货到付款，但是支付走自己的paypal流程，只有支付成功才会下单。因此mobile的下单都是支付成功的。(后续发货流程，应该根据paypal上显示的收入来确定一定付款了。理论上网站不会出错)

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

//1、添加商品
// $arrProducts = array(
// 	array(
// 		"product_id" => "5972",
// 		"qty" => 2
// 	)
// );

// $result = $client->call($session, 'cart_product.add', array('401',$arrProducts,'16'));

//2、游客信息设置
$customerAsGuest = array(
	"firstname" => "testFirstname",
	"lastname" => "testLastName",
	"email" => "123@123.com",
	"website_id" => "base",
	"store_id" => "china",
	"mode" => "guest"
);
// $result = $client->call($session,'cart_customer.set',array('401',$customerAsGuest));

//2、设置账单地址和配送地址
$arrAddresses = array(
	array(
		"mode" => "shipping",
		"firstname" => "testFirstname",
		"lastname" => "testLastname",
		"company" => "testCompany",
		"street" => "testStreet",
		"city" => "testCity",
		"postcode" => "123",
		"country_id" => "CA",
		"region_id" => "74",
		"telephone" => "0123456789",
		"fax" => "0123456789",
		"is_default_shipping" => 0,
		"is_default_billing" => 0
	),
	array(
		"mode" => "billing",
		"address_id" => "",
		"firstname" => "testFirstname",
		"lastname" => "testLastname",
		"company" => "testCompany",
		"street" => "testStreet",
		"city" => "testCity",
		"postcode" => "123",
		"country_id" => "CA",
		"region_id" => "74",
		"telephone" => "0123456789",
		"fax" => "0123456789",
		"is_default_shipping" => 0,
		"is_default_billing" => 0
	)
);
// $result = $client->call($session,'cart_customer.addresses',array('401',$arrAddresses));

//3、配置支付方式(支付方式是空的，我们走mobile自己的paypal支付，然后成功后直接下单)
$paymentMethod = array(
	"method" => "Null"
);
// $result = $client->call($session,'cart_payment.list','401');
// $result = $client->call($session,'cart_payment.method',array('401',$paymentMethod));


//4、配置运送方式，满39刀有免费支付，否者是6刀的配送
// $result = $client->call($session,'cart_shipping.list','401');
// $result = $client->call($session,'cart_shipping.method',array('401','freeshipping_freeshipping'));

//5、设置支付方式
// $result = $client->call($session,'cart_payment.list','401');
$paymentMethod = array(
	"method" => "cashondelivery"
);
// $result = $client->call($session,'cart_payment.method',array('401',$paymentMethod));

//6、下订单(自己的支付流程通过后)
$result = $client->call($session,'cart.order',array('401'));
//return string(10) "1600000089"

//ps1、显示购物车信息
// $result = $client->call($session,'cart.info','401');


var_dump($result);

?>