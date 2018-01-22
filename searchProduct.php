<?php

$searchword=$_GET['s'];
$arr = mb_str_split($searchword);
$arr_str = join("%",$arr);
$regx = "%".$arr_str."%";

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

//keyword搜索
$complexFilter = array(
            'meta_keyword' => array('like' => $regx)
);

$args = array(
	'filters' => $complexFilter,
	'storeView' => '16'
);

$result = $client->call($session,'catalog_product.list',$args);

//名称搜索
$complexFilter_name = array(
        'name' => array('like' => $regx)
);
$args_name = array(
	'filters' => $complexFilter_name,
	'storeView' => '16'
);
$result_name = $client->call($session,'catalog_product.list',$args_name);

echo json_encode(array_merge($result,$result_name));

function mb_str_split($str){  
    return preg_split('/(?<!^)(?!$)/u', $str );  
} 


?>