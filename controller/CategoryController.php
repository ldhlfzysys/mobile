<?php  
require_once('model/CategoryModel.php');
require_once('model/ProductModel.php');
class CategoryController  {  

	// 跳转到商品分类界面
	function toCategoryView($param)  {  
		// $categoryArray=array();
		// $categoryArray['热卖'] = '100';
		// $categoryArray['新品'] = '106';
		// $categoryArray['折扣'] = '105';
		// $categoryArray['日韩零食'] = '255';
		// $categoryArray['生鲜水果'] = '256';
		// $categoryArray['休闲零食'] = '64';
		// $categoryArray['饼干糕点'] = '79';
		// $categoryArray['糖果巧克力'] = '92';
		// $categoryArray['冲调饮品'] = '107';
		// $categoryArray['坚果蜜饯'] = '128';
		// $categoryArray['粮油调味'] = '141';
		// $categoryArray['酒水饮料'] = '135';
		// $categoryArray['方便速食'] = '113';
		// $categoryArray['个人护理'] = '122';
		// $categoryArray['生活日用'] = '163';
		// $categoryArray['生鲜速冻'] = '178';
		// $categoryArray['急冻生鲜'] = '185';

		// $categoryModel = new CategoryModel();
		// $categoryTree = $categoryModel->categoryTree();
		// $categoryTree = $categoryTree['children'][0]['children'];
		// $categoryIDDic;
		// foreach ($categoryTree as $category1) {
		// 	if (count($category1['children']) <= 0) {
		// 		$id = $category1['category_id'];
		// 		$categoryIDDic[$id] = $id;
		// 	}
		// 	#兼容个别同时存在于3级分类和2级分类的产品
		// 	else{
		// 		$id = $category1['category_id'];
		// 		$categoryIDDic[$id] = $id;
		// 		foreach ($category1['children'] as $category2) {
		// 			$id1 = $category2['parent_id'];
		// 			$id2 = $category2['category_id'];
		// 			$categoryIDDic[$id2] = $id1;
		// 		}
		// 	}
		// }

		// // 商品列表
		// // $productListUrl=$baseHost . 'productList.php';
		// // $html = file_get_contents($productListUrl);

		// $productModel = new ProductModel();
		// $productList = $productModel->productList();
		// $newProductList;
		// foreach ($productList as $product) {
		// 	$category_ids = $product['category_ids'];
		// 	//防止重复添加
		// 	$norepeat = array();
		// 	foreach ($category_ids as $key => $category_id) {
		// 		$id1 = $categoryIDDic[$category_id];
		// 		if (!isset($newProductList[$id1])) {
		// 			$newProductList[$id1] = array();
		// 		}
		// 		if (!in_array($id1, $norepeat)) {
		// 			array_push($norepeat,$id1);
		// 			array_push($newProductList[$id1], $product);	
		// 		}
		// 	}
		// }

		// $length = count($newProductList);
		require('view/Category.php');  

		// require('view/testView.php');
		// echo "test";
	}  

	
}  















?>