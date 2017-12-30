<?php


#传入商品id和数量，数量为整形，商品id为字符串

	$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	$params = array('email'=>'411455886@qq.com', 'password'=>'11180x119');
 	
 	try {

    	$result = $client->call($session, 'customer.mlogin', $params);
	}
	catch (Exception $e) { //while an error has occured
	    echo "==> Error: ".$e->getMessage();
	}
	echo $result;

?>