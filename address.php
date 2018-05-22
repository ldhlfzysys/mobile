<?php
ini_set('display_errors',1); 
ini_set('display_startup_errors',1);


function customer_address($userid){
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	// $result = $client->call($session, 'customer.list');
	$result = $client->call($session, 'customer_address.list', $userid);
	return $result;
}

function customer_address_delete($addressid)
{
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	// $result = $client->call($session, 'customer.list');
	$result = $client->call($session, 'customer_address.delete', $addressid);
	return $result;
}

function customer_address_update($type,$addressid)
{
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	if ($type == 0) {//设置收货地址
		$data = array('addressId' => $addressid, 'addressdata' => array('is_default_shipping' => true));
	}else{
		$data = array('addressId' => $addressid, 'addressdata' => array('is_default_billing' => true));
	}
	$result = $client->call($session, 'customer_address.update', $data);
	return $result;
}

function customer_address_create($userid,$firstname,$lastname,$tele,$postcode,$area,$street,$isDefaultBilling,$isDefaultShipping){
	$address_data = array(
		'customerId' => $userid, 
		'addressdata' => 
		array(
			'firstname' => $firstname, 
			'lastname' => $lastname, 
			'street' => array($street), 
			'city' => $area, 
			'country_id' => 'CA', 
			'region' => 'Ontario', 
			'region_id' => 74, 
			'postcode' => $postcode, 
			'telephone' => $tele, 
			'is_default_billing' => $isDefaultBilling, 
			'is_default_shipping' => $isDefaultShipping
			)
	);
	$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
	$session = $client->login('mobile', 'mobile');
	// $result = $client->call($session, 'customer.list');
	$result = $client->call($session, 'customer_address.create', $address_data);
	return $result;
}

//删除地址
if (isset($_POST['delete_address']) && isset($_POST['address_id'])) {
	return customer_address_delete($_POST['address_id']);
}

//新建账单地址
if (isset($_POST['uid']) && isset($_POST['type']) && isset($_POST['slastname']) && isset($_POST['sfirstname']) && isset($_POST['sphone']) && isset($_POST['spostcode']) && isset($_POST['sarea']) && isset($_POST['sstreet'])) {
	if ($_POST['type'] == 0) {
		return customer_address_create($_POST['uid'],$_POST['sfirstname'],$_POST['slastname'],$_POST['sphone'],$_POST['spostcode'],$_POST['sarea'],$_POST['sstreet'],false,true);	
	}else if($_POST['type'] == 1){
		return customer_address_create($_POST['uid'],$_POST['sfirstname'],$_POST['slastname'],$_POST['sphone'],$_POST['spostcode'],$_POST['sarea'],$_POST['sstreet'],true,false);	
	}else{
		return customer_address_create($_POST['uid'],$_POST['sfirstname'],$_POST['slastname'],$_POST['sphone'],$_POST['spostcode'],$_POST['sarea'],$_POST['sstreet'],true,true);	
	}
	
}

//更新地址
//update=0  设置默认收货地址
//update=1  设置默认账单地址
if (isset($_POST['update']) && isset($_POST['address_id'])) {
	return customer_address_update($_POST['update'],$_POST['address_id']);
}

// var_dump(customer_address_update(0,'29'));
?>