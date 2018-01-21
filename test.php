<?php
ini_set('display_errors',1); 
ini_set('display_startup_errors',1);

// $searchword=$_GET['s'];

$client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
  
$session = $client->login('mobile', 'mobile');

$xx="黑力";
$arr = mb_str_split($xx);
$regx = join("%",$arr);
$dd = "%".$regx."%";



$complexFilter = array(
            'name' => array('like' => $dd)
);

$args = array(
	'filters' => $complexFilter,
	'storeView' => '16'
);

$result = $client->call($session,'catalog_product.list',$args);

var_dump($result);
function mb_str_split($str){  
    return preg_split('/(?<!^)(?!$)/u', $str );  
}  


?>