<?php
header("Content-type:text/html;charset=utf-8"); 

include_once('./cart.php');
include_once('./config.php');
include_once('./test.php');
#使用方式：

function userid(){
	if (isset($_COOKIE['bdb-ui'])) {
		return $_COOKIE['bdb-ui'];   //用户id	
	}
	return null;
}


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

// 更新密码
function updatePassword($password,$userid){
	try{
		$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
		$session = $client->login('mobile', 'mobile');
		$args = array(
			'customerId' => $userid, 
			'customerData' => array(
				'password' => $password
			)
		);
		$result = $client->call($session, 'customer.update', $args);
		$client->endSession($session);
		$res = array(
			'status' =>0,
			'msg'=>"操作成功",
			'userid'=>$userid,
			'args' => $args
		);
		
	}catch(Exception $e){
		$res['status'] = -1;
		$res['msg'] = '操作失败';
		 // $e->getMessage();
	}
	return $res;
}

// 通过邮件查询用户信息
function getUserByEmail($email){
    $client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
    $session = $client->login('mobile', 'mobile');
    $filters = array(
        array(
            "email" => $email
        )
    );
    $result = null;
    try {
        $result = $client->call($session, 'customer.list',$filters);
    }catch (Exception $e) { //while an error has occured
        $result = "==> Error: ".$e->getMessage();
    }
    return $result;
}

// 通过邮件查询用户
if (isset($_GET['queryUser']) && isset($_GET['email'])) {
	$email = $_GET['email'];
	$res = getUserByEmail($email);
	echo json_encode($res);
}


// 用户重置密码
if (isset($_POST['resetPassword']) && isset($_POST['password'])) {
	$password = $_POST['password'];
	$userid = userid();
	$result = null;
	if ($userid == null) {
		$result = array(
			'status' =>-2,
			'msg'=>"用户登录失效",
		);
	}else{
		$result = updatePassword($password,$userid);
	}
	echo json_encode($result);
}

// 用户找回密码 重置
if (isset($_POST['getPassword']) && isset($_POST['password']) && isset($_POST['userid']) && isset($_POST['tocken'])) {
	$password = $_POST['password'];
	$userid = $_POST['userid'];
	$tocken = $_POST['tocken'];

	$res = array(
		"status" => 0,
		"msg" => "操作成功"
	);

	if(!isset($password)){
		$res['status'] = -1;
		$res['msg'] = "请输入设置的密码";
		echo json_encode($res);
		return;
	}

	if ( !isset($tocken) || !isset($userid) ) {
		$res['status'] = -1;
		$res['msg'] = "无效的连接，请重新发送邮件";
	}else{
		// 验证tocken 和 用户
		$redis = new Redis();
        $redis->connect($redisHost, $redisPort);
        $localTocken = $redis->get($userid . '_tocken');
        if ($localTocken != $tocken) {
        	$res['status'] = -1;
			$res['msg'] = "tocken失效,请重新发送邮件";
        }else{
        	// 更新用户密码
        	$res = updatePassword($password,$userid);
        }
	}

	echo json_encode($res);
	return;
}


?>