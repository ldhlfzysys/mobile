<?php
class CategoryModel{

	// 商品种类
	function categoryTree() {
		// redis判断
		// $redis = RedisModel::getRedis();
		// $redis_key = 'productTreeAll';
		// $redis_result = $redis->get($redis_key);
		// if ($redis_result) {
		// 	return json_decode($redis_result);
		// }

		$client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl'); 
		$session = $client->login('mobile', 'mobile');
		$result = $client->call($session, 'catalog_category.tree');
		$client->endSession($session);
		
		// $json_result = json_encode($result);
		// $redis->set($redis_key,$json_result);

		return $result;
	}
}

?>