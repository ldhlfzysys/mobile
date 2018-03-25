<?php
header("Content-type:text/html;charset=utf-8"); 

include_once('./cart.php');
#使用方式：

function userid(){
	if (isset($_COOKIE['bdb-ui'])) {
		return $_COOKIE['bdb-ui'];   //用户id	
	}
	return null;
}

include_once('./test.php');
// 获取购物车ID 许雷
function cartid(){
	// $cartid =getLocalCart();
	// return $cartid;

	$userid = userid();
	$cartid = null;
	if ($userid == null) {
		// 用户未登录，使用本地原来购物车
		$cartid = getLocalCart();
	}else{
		// 用户已登录，获取PC端购物车并检查是否可用
		$cartid = getCartIdByUser($userid);
		if ($cartid == 0) {
			# PC端还没有购物车
			return getLocalCart();
		}
		// PC购物车信息
		$cartInfo = null;
		try{
			$cartInfo = cart($cartid);
		}catch (Exception $e) {
			return getLocalCart();
		}
		if ($cartInfo == null) {
			return getLocalCart();
		}
		if($cartInfo['payment'] != null && $cartInfo['payment']['payment_id'] != null){
			// PC端购车不可用，使用本地购物车
			$cartid = getLocalCart();
		}else{
			// 原来本地购物车合并到PC端购物车
			$localCartid = getLocalCart();
			// 本地购物车信息
			$localCartInfo = cart($localCartid);

			// 要从本地删除的商品
			$arrProducts = array();
			// 将本地购物车商品添加到PC购物车
			foreach ($localCartInfo['items'] as $key => $value) {
				$product_id = $value['product_id'] . "";
				addToCart($cartid,$product_id,$value['qty']); // 添加PC购物车
				// 从本地购物车移除，否则会导致多次添加
				array_push($arrProducts,array("product_id" => $product_id,"qty" => "0"));
			}
			if(count($arrProducts) > 0){
				removeCart($arrProducts,$localCartid);
			}
			
		}
	}
	return $cartid;
}

// 获取本地缓存购物车或者创建 许雷
function getLocalCart(){
	if (isset($_COOKIE['bdb-ci'])) {
		return $_COOKIE['bdb-ci'];// 购物车ID
	}else{
		$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
		$session = $client->login('mobile', 'mobile');
		$result = $client->call( $session, 'cart.create', '16');
		$cartid = $result;
		setcookie('bdb-ci',$cartid);
		return $cartid;
	}
}

function userinfo(){
	if (isset($_COOKIE['bdb-uf'])) {
		return json_decode($_COOKIE['bdb-uf'],true);
	}else if (userid() == null) {
		return null;
	}
	else
	{
		$userid = userid();
		$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
		$session = $client->login('mobile', 'mobile');
		// $result = $client->call($session, 'customer.list');
		$result = $client->call($session, 'customer.info', $userid);
		$userinfo = $result;
		setcookie('bdb-uf',json_encode($userinfo));
		return $userinfo;
	}

}

function islogin(){
	if (isset($_COOKIE['bdb-ui'])) {
		return true;
	}else{
		return false;
	}
}


function username(){
	$userinfo = userinfo();
	if ($userinfo == null) {
		return '游客';
	}else{
		return $userinfo['lastname'].$userinfo['middlename'].$userinfo['firstname'];
	}
}


?>