<?php
ini_set('display_errors',1);
#传入商品id和数量，数量为整形，商品id为字符串
function addToCart($cartid,$product_id,$qty){
	$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$arrProducts = array(
		array(
			"product_id" => $product_id,
			"qty" => $qty
			)
	);
 	$result = $client->call($session, 'cart_product.add', array($cartid,$arrProducts,'16'));
 	echo json_encode($result);
}

function cart($cartid){
	$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$args = array(
	    'store' => '16'
		);
	$result = $client->call($session, 'cart.info',$cartid, $args);
	return $result;
}

if (isset($_GET['addToCart']) && isset($_GET['productId'])) {
	$cartId = $_GET['addToCart'];
	$productId = $_GET['productId'];
	$result = addToCart($cartId,$productId,1);
	echo $result;
}

?>