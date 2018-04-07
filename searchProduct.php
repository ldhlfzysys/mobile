<?php

$searchword=$_GET['s'];
$arr = mb_str_split($searchword);
$arr_str = join("%",$arr);
$regx = "%".$arr_str."%";

$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

//keyword搜索
$complexFilter = array(
            'meta_keyword' => array('like' => $regx),
            'status' => 1
);

$args = array(
	'filters' => $complexFilter,
	'storeView' => '16'
);

$result = $client->call($session,'catalog_product.list',$args);

//名称搜索
$complexFilter_name = array(
        'name' => array('like' => $regx),
        'status' => 1
);
$args_name = array(
	'filters' => $complexFilter_name,
	'storeView' => '16'
);
$result_name = $client->call($session,'catalog_product.list',$args_name);

$result_merge = array_merge($result,$result_name);

$result_unequal = array();
foreach ($result_merge as $item) {
	$result_unequal += [$item['product_id'] => $item ];
}

echo json_encode(array_values($result_unequal));

function mb_str_split($str){  
    return preg_split('/(?<!^)(?!$)/u', $str );  
} 


?>