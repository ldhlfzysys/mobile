<?php
class UserModel{

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

	
}

?>