<?php
header("Content-type:text/html;charset=utf-8"); 

#使用方式：

function userid(){
	$userid = $_COOKIE['bdb-ui'];   //用户id	
	return $userid;

}

function cartid(){
	$cartid = $_COOKIE['bdb-ci'];   //购物车id
	if ($cartid == null) {
		$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
		$session = $client->login('mobile', 'mobile');
		$result = $client->call( $session, 'cart.create');
		$cartid = $result;
		setcookie('bdb-ci',$cartid);
	}else{
		return $cartid;
	}
}

function userinfo(){
	$userinfo = $_COOKIE['bdb-uf']; //用户信息 "customer_id" "confirmation" "email" "firstname" "lastname" "middlename"	
	$userid = userid();
	if ($userid == null) {
		return null;
	}
	else if($userinfo == null)
	{
		$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
		$session = $client->login('mobile', 'mobile');
		// $result = $client->call($session, 'customer.list');
		$result = $client->call($session, 'customer.info', $userid);
		$userinfo = $result;
		setcookie('bdb-uf',json_encode($userinfo));
		return $userinfo;
	}else{
		return $userinfo;
	}

}

function islogin(){
	$userid = $_COOKIE['bdb-ui'];   //用户id	
	if ($userid == null) {
		return false;
	}else{
		return true;
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

function login(){

}

?>