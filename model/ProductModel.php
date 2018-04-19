<?php
// require_once('../config.php');
// require_once('RedisModel.php');
class ProductModel{

	// 通过ids字符串查询商品
	function getProductInfoByIds($ids) {
		$lists = explode('-', $ids);
		$result = array();

		// redis判断
		// $redis = RedisModel::getRedis();
		// $redis_key = 'productInfo'.$ids;
		// $redis_result = $redis->get($redis_key);
		// if ($redis_result) {
		// 	return json_decode($redis_result);
		// }

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

	// 商品列表
	function productList(){
		// redis判断
		// $redis = RedisModel::getRedis();
		// $redis_key = 'productlistall';
		// $redis_result = $redis->get($redis_key);
		// if ($redis_result) {
			// return json_decode($redis_result);
		// }

		$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
		$session = $client->login('mobile', 'mobile');
		$complexFilter = array(
	            'status' => 1
		);
		$args = array(
		    'filters' => $complexFilter,
		    'storeView' => '16'
		);
		$result = $client->call($session, 'catalog_product.list',$args);
		$client->endSession($session);
		// $json_result = json_encode($result);
		// $redis->set($redis_key,$json_result);
		return $result;
	}














}

?>