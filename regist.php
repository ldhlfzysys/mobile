<?php


function regist($firstname,$lastname,$email,$password){
	$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
 	$params = array(array('email' =>$email, 'firstname' => $firstname, 'lastname' => $lastname, 'password' => $password, 
 		'website_id' => 1, 'store_id' => 16, 'group_id' => 1));
 	
 	try {
 		$result = $client->call($session,'customer.create',$params);
	}
	catch (Exception $e) { //while an error has occured
	    echo "==> Error: ".$e->getMessage();
	}
	echo $result;
}

if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['password']) ) {
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$result = login("936566715@qq.com","team365");
	echo $result;
}
?>