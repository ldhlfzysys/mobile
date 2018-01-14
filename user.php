<?php
header("Content-type:text/html;charset=utf-8"); 

#使用方式：

function userid(){
	if (isset($_COOKIE['bdb-ui'])) {
		return $_COOKIE['bdb-ui'];   //用户id	
	}
	return null;
}

function cartid(){
	if (isset($_COOKIE['bdb-ci'])) {
		return $_COOKIE['bdb-ci'];
	}else{
		$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
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
		$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
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