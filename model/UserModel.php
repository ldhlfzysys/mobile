<?php
require_once('model/CartModel.php');

class UserModel{

	// 获取用户ID
	function userid(){
		if (isset($_COOKIE['bdb-ui'])) {
			return $_COOKIE['bdb-ui'];   //用户id	
		}
		return null;
	}

	function userinfo(){
		if (isset($_COOKIE['bdb-uf'])) {
			return json_decode($_COOKIE['bdb-uf'],true);
		}else if (userid() == null) {
			return null;
		}else{
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


	// 获取购物车ID 许雷
	function getCartId(){
		$userid = $this->userid();
		$cartid = null;
		if ($userid == null) {
			// 用户未登录，使用本地原来购物车
			$cartid = $this->getLocalCart();
		}else{
			// 用户已登录，获取PC端购物车并检查是否可用
			$cartid = $this->getCartIdByUser($userid);
			if ($cartid == 0) {
				# PC端还没有购物车
				return $this->getLocalCart();
			}
			// PC购物车信息
			$cartModel = new CartModel();
			$cartInfo = null;
			try{
				$cartInfo = $cartModel->cart($cartid);
			}catch (Exception $e) {
				return $this->getLocalCart();
			}
			if ($cartInfo == null) {
				return $this->getLocalCart();
			}
			if($cartInfo['payment'] != null && $cartInfo['payment']['payment_id'] != null){
				// PC端购车不可用，使用本地购物车
				$cartid = $this->getLocalCart();
			}else{
				// 原来本地购物车合并到PC端购物车
				$localCartid = $this->getLocalCart();
				// 本地购物车信息
				$localCartInfo = $cartModel->cart($localCartid);

				// 要从本地删除的商品
				$arrProducts = array();
				// 将本地购物车商品添加到PC购物车
				foreach ($localCartInfo['items'] as $key => $value) {
					$product_id = $value['product_id'] . "";
					$cartModel->addToCart($cartid,$product_id,$value['qty']); // 添加PC购物车
					// 从本地购物车移除，否则会导致多次添加
					array_push($arrProducts,array("product_id" => $product_id,"qty" => "0"));
				}
				if(count($arrProducts) > 0){
					$cartModel->removeCart($arrProducts,$localCartid);
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
			// 创建购物车
			$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
			$session = $client->login('mobile', 'mobile');
			$result = $client->call( $session, 'cart.create', '16');
			$cartid = $result;
			setcookie('bdb-ci',$cartid);
			return $cartid;
		}
	}

	// 通过用户ID获取购物车
	function getCartIdByUser($userId){
        $client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
        $session = $client->login('mobile', 'mobile');
        $params = array('customerid'=>$userId);
        $args = array('store' => '16');
        try {

            //过的购物车id
            $result = $client->call($session, 'cart.quotebyuserid', $params);
            return $result;
            // $result = $client->call($session, 'cart.info','268', $args);
        }catch (Exception $e) { //while an error has occured
            echo "==> Error: ".$e->getMessage();
            return null;
        }
        // var_dump($result);
    }

	
}

?>