<?php
ini_set('display_errors',1);
#传入商品id和数量，数量为整形，商品id为字符串
function addToCart($cartid,$product_id,$qty){
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
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

function updateCart($products,$cartid){
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
 	$result = $client->call($session, 'cart_product.update', array($cartid,$products,'16'));
 	echo json_encode($result);
}

function removeCart($products,$cartid){
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
 	$result = $client->call($session, 'cart_product.remove', array($cartid,$products,'16'));
 	echo json_encode($result);
}

// 清空购物车商品
function cleanCart($cartid){
	$cartInfo = cart($cartid);

	// 要从本地删除的商品
	$arrProducts = array();
	// 将本地购物车商品添加到PC购物车
	foreach ($cartInfo['items'] as $key => $value) {
		$product_id = $value['product_id'] . "";
		// 从本地购物车移除，否则会导致多次添加
		array_push($arrProducts,array("product_id" => $product_id,"qty" => "0"));
	}
	if(count($arrProducts) > 0){
		removeCart($arrProducts,$cartid);
	}
	
}

function cart($cartid){
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$args = array(
	    'store' => '16'
		);
	try{
		$result = $client->call($session, 'cart.info',$cartid, $args);
		return $result;
	}catch (Exception $e){
		return null;
	}
	
}

if (isset($_GET['addToCart']) && isset($_GET['productId'])) {
	$cartId = $_GET['addToCart'];
	$productId = $_GET['productId'];
	$result = addToCart($cartId,$productId,1);
	echo $result;
}

// 更新购物车
if (isset($_GET['updateCart']) && isset($_GET['cartid'])) {
	$str = $_GET['updateCart'];
	$array = json_decode($str,true);
	$cartid = $_GET['cartid'];
	$result = updateCart($array,$cartid);
	echo $result;

}

if (isset($_GET['remove']) && isset($_GET['cartid'])) {
	$str = $_GET['remove'];
	$array = json_decode($str,true);
	$cartid = $_GET['cartid'];
	$result = removeCart($array,$cartid);
	echo $result;

}

?>