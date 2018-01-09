<?php 

#完整的下单流程，到这一步，所有信息都已经有了，否则就要报错
function order(){
	$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');

	$userid = null;
	$cartid = null;
	$userinfo = null;
	//判断是游客还是用户
	if (isset($_COOKIE['bdb-ui'])) {
		$userid = $_COOKIE['bdb-ui'];
	}

	//用户信息
	if (isset($_COOKIE['bdb-uf'])) {
		$userinfo = $_COOKIE['bdb-uf'];
	}else if ($userid == null) {
		$userinfo = null;
	}
	else if($userinfo == null)
	{
		$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
		$session = $client->login('mobile', 'mobile');
		// $result = $client->call($session, 'customer.list');
		$result = $client->call($session, 'customer.info', $userid);
		$userinfo = $result;
		setcookie('bdb-uf',json_encode($userinfo));
	}else{
		return null;
	}

	//购物车
	if (isset($_COOKIE['bdb-ci'])) {
		$cartid = $_COOKIE['bdb-ci'];
	}

	//如果没有用户信息，构造一个游客信息并添加到购物车
	if ($userinfo == null) {
		$userinfo = array(
			"firstname" => "游",
			"lastname" => "客",
			"email" => "service@bdbbuy.com",
			"website_id" => "base",
			"store_id" => "china",
			"mode" => "guest"
		);
	}

	//到目前，如果关键数据缺失，返回错误
	if (empty($)) {
		# code...
	}

	//设置用户信息到购物车
	$result = $client->call($session,'cart_customer.set',array($cartid,$userinfo));
}




?>