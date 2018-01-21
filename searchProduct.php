<?php

$searchword=$_GET['s'];
$arr = mb_str_split($searchword);
$arr_str = join("%",$arr);
$regx = "%".$arr_str."%";

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

$complexFilter = array(
            'name' => array('like' => $regx)
);

$args = array(
	'filters' => $complexFilter,
	'storeView' => '16'
);

$result = $client->call($session,'catalog_product.list',$args);

echo json_encode($result);


function mb_str_split($str){  
    return preg_split('/(?<!^)(?!$)/u', $str );  
} 


?>