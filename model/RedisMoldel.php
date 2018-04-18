<?php
require_once('../config.php');
class RedisModel{

	// 获取一个redis连接
	function getRedis($ids) {
		$redis = new Redis();
		$redis->connect($redisHost,$redisPort);
		return $result;
	}

	
}

?>