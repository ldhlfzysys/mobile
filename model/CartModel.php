<?php
/**
* 购物车
*/
class CartModel {
	
	// 通过购物侧ID，查询购物车信息
	function getCartInfo($cartid){
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

	// 传入商品id和数量，数量为整形，商品id为字符串
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
	 	return $result;
	}

	// 删除商品
	function removeCart($products,$cartid){
		$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
		$session = $client->login('mobile', 'mobile');
	 	$result = $client->call($session, 'cart_product.remove', array($cartid,$products,'16'));
	 	return $result;
	}


}



?>