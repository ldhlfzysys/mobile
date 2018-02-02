<?php

// $client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
// $session = $client->login('mobile', 'mobile');

  

// $complexFilter = array(
//             'status' => 1
// );

// $args = array(
// 	'filters' => $complexFilter,
// 	'storeView' => '16'
// );

// $result = $client->call($session,'catalog_product.list',$args);


// echo json_encode($result);

function descTime($orderList){
	$sort = array(
	    'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
	    'field'     => 'time',       //排序字段
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

$orderList = array(
	array(
		"time" =>"2018-02-02 21:18:42",
	),
	array(
		"time" =>"2018-02-01 21:18:42",
	),
	array(
		"time" =>"2018-02-03 21:18:42",
	),
);



 var_dump($orderList)
?>