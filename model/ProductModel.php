<?php
class ProductModel{

	// 通过ids字符串查询商品
	function getProductInfoByIds($ids) {
		$lists = explode('-', $ids);
		$result = array();

		$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
		$session = $client->login('mobile', 'mobile');
		foreach ($lists as $id){ 
			$args = array(
		    'productId' => $id,
		    'storeView' => 'china'
			);
			$res = $client->call($session, 'catalog_product.info', $args);
			array_push($result, $res);
		}
		$client->endSession($session);
		// $redis->set($redis_key,json_encode($result));
		// echo json_encode($result);
		return $result;
	}
}

?>