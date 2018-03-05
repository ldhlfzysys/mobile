<?php

function login($userid,$password){
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
 	$params = array('email'=>$userid, 'password'=>$password);
 	
 	try {

    	$result = $client->call($session, 'customer.mlogin', $params);
	}
	catch (Exception $e) { //while an error has occured
	    echo "==> Error: ".$e->getMessage();
	}
	echo $result;
}

// $result = login("wudishentu239@163.com","insomnia0903");
// $obj = json_decode($result,true);
// var_dump(json_decode($result,true));
// if ($obj['status'] == 'OK') {
// 	$userid = $obj['userData']['customer_id'];
// 	setcookie('bdb-ui',$userid);
// }

if (isset($_POST['userid']) && isset($_POST['password'])) {
	$userid = $_POST['userid'];
	$password = $_POST['password'];
	$result = login($userid,$password);
	echo $result;
}
?>