<?php
ini_set('display_errors',1); 
ini_set('display_startup_errors',1);

// 按照订单创建时间，降序
function descByTime($orderList){
	$sort = array(
	    'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
	    'field'     => 'created_at',       //排序字段
	 );
	$arrSort = array();
	foreach($orderList AS $uniqid => $row){
	    foreach($row AS $key=>$value){
	        $arrSort[$key][$uniqid] = $value;
	    }
	}
	if($sort['direction']){
	    array_multisort($arrSort[$sort['field']], constant($sort['direction']), $orderList);
	}
	return $orderList;
}

function getOrderList($userid){

	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);

	$redis_key = 'OrderListAll';
	$redis_result = $redis->get($redis_key);
	$result;
	if ($redis_result) {
		$result = $redis_result;
	}else{
		$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
		$session = $client->login('mobile', 'mobile');
		$result = $client->call($session, 'order.list');
	}

	// 排序
	$result = descByTime($result);

	$myOrderList = array();
	foreach ($result as $key => $value) {
		if ($value['customer_id'] == $userid) {
			array_push($myOrderList, $value);
		}
	}
	return $myOrderList;
}

if (isset($_GET['userid'])) {
	$result = getOrderList($_GET['userid']);
	$json_result = json_encode($result);
	echo $json_result;
}else
{
	echo '<script type="text/javascript">';
	echo 'window.location.href="https://m.bdbbuy.com/login.html";';
	echo '</script>';
}


?>