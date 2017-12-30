<?php

#传入商品id和数量，数量为整形，商品id为字符串
function addToCart($product_id,$qty){
	$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$arrProducts = array(
		array(
			"product_id" => $product_id,
			"qty" => $qty
			)
	);
 	$result = $client->call($session, 'cart_product.add', array($cartid,$arrProducts));
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

?>