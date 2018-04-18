<?php  
	require_once('model/TestModel.php');
	class DemoController  {  
		// 默认方法
		function index($param)  {  

			$param = json_encode($param);
			
			$model = new TestModel();
			$data = $model -> getData();
			require('view/index.php');  
			// echo "test";
		}  
	}  

?>