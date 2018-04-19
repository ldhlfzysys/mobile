<?php

include_once('./config.php');
include_once('./imagePathFix.php');
require_once('model/CategoryModel.php');
require_once('model/ProductModel.php');
require_once('model/UserModel.php');


$categoryArray=array();
$categoryArray['热卖'] = '100';
$categoryArray['新品'] = '106';
$categoryArray['折扣'] = '105';
$categoryArray['日韩零食'] = '255';
$categoryArray['生鲜水果'] = '256';
$categoryArray['休闲零食'] = '64';
$categoryArray['饼干糕点'] = '79';
$categoryArray['糖果巧克力'] = '92';
#$categoryArray['冲调饮品'] = '107';
$categoryArray['坚果蜜饯'] = '128';
$categoryArray['粮油调味'] = '141';
$categoryArray['酒水饮料'] = '135';
$categoryArray['方便速食'] = '113';
$categoryArray['个人护理'] = '122';
$categoryArray['生活日用'] = '163';
#$categoryArray['生鲜速冻'] = '178';
#$categoryArray['急冻生鲜'] = '185';

// $categoryArray['精选推荐'] = '258';
// $categoryArray['精选生鲜水果'] = '259';
// $categoryArray['精选休闲零食'] = '260';
// $categoryArray['精选糖果巧克力'] = '261';
// $categoryArray['精选饼干糕点'] = '262';
// $categoryArray['精选坚果蜜饯'] = '263';
// $categoryArray['精选方便速食'] = '264';
// $categoryArray['精选个人护理'] = '265';

// $categoryUrl= $baseHost . 'categoryTree.php';
// $html = file_get_contents($categoryUrl);
// $categoryTree = json_decode($html,true);

$categoryModel = new CategoryModel();
$categoryTree = $categoryModel->categoryTree();


$categoryTree = $categoryTree['children'][0]['children'];
$categoryIDDic;
foreach ($categoryTree as $category1) {
	if (count($category1['children']) <= 0) {
		$id = $category1['category_id'];
		$categoryIDDic[$id] = $id;
	}
	#兼容个别同时存在于3级分类和2级分类的产品
	else
	{
		$id = $category1['category_id'];
		$categoryIDDic[$id] = $id;
		foreach ($category1['children'] as $category2) {
			$id1 = $category2['parent_id'];
			$id2 = $category2['category_id'];
			$categoryIDDic[$id2] = $id1;
		}
	}
}

// $productListUrl=$baseHost . 'productList.php';
// $html = file_get_contents($productListUrl);
// $productList = json_decode($html,true);

$productModel = new ProductModel();
$productList = $productModel->productList();

$newProductList;
foreach ($productList as $product) {
	$category_ids = $product['category_ids'];
	//防止重复添加
	$norepeat = array();
	foreach ($category_ids as $key => $category_id) {
		$id1 = $categoryIDDic[$category_id];
		if (!isset($newProductList[$id1])) {
			$newProductList[$id1] = array();
		}
		if (!in_array($id1, $norepeat)) {
			array_push($norepeat,$id1);
			array_push($newProductList[$id1], $product);	
		}
		
	}
}

// $cartId = cartid();
$userModel = new UserModel();
$cartId = $userModel->getCartId();

?>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui"/>
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
	<meta name="format-detection" content="telephone=no, email=no"/>
	<meta charset="UTF-8">
	<title>八点半买</title>
	<link rel="stylesheet" href="themes/css/core.css">
	<link rel="stylesheet" href="themes/css/icon.css">
	<link rel="stylesheet" href="themes/css/home.css">
	<link rel="stylesheet" href="themes/css/add.css">
	<script src="themes/js/sweetalert2.js"></script>
	<link rel="stylesheet" href="themes/css/amazeui.min.css">
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<link href="iTunesArtwork@2x.png" sizes="114x114" rel="apple-touch-icon-precomposed">
</head>
<body>
	长度：<?php echo $length; ?>
	<header class="aui-header-default aui-header-fixed aui-header-bg">
		<a href="#" class="aui-header-item" style="display:none">
			<i class="aui-icon aui-icon-code"></i>
		</a>
		<div class="aui-header-center aui-header-center-clear">
			<div class="aui-header-search-box">
				<i class="aui-icon aui-icon-small-search"></i>
				<form action="searchProduct.phtml" method="get">
					<input id="" name="s" type="search"  placeholder="请输入搜索关键字" class="aui-header-search">
				</form>
			</div>
		</div>
		<a href="#" class="aui-header-item-icon">
			<i class="aui-icon aui-icon-packet" style="display:none"></i>
			<i class="aui-icon aui-icon-member" style="display:none"></i>
		</a>
	</header>
	<section class="aui-scroll-contents">
		<div class="aui-scroll-box" data-ydui-scrolltab>
			<div class="aui-scroll-nav">
				<div class="tab_menu">
				<ul style="width:5.3rem">
					<?php
					$firstDone = FALSE;
			        foreach ($categoryArray as $key => $value) {
			        	if ($firstDone) {
			        		echo '<li>';
			        	}else
			        	{
			        		echo '<li class="on">';
			        		$firstDone = TRUE;
			        	}
			        	echo '<a href="#" class="aui-scroll-item">';
			        	echo '<div class="aui-scroll-item-icon"></div>';
			        	echo '<div class="aui-scroll-item-text">'.$key.'</div>';
			        	echo '</a>';
			        	echo '</li>';							
			        }
					?>
				</ul>
				</div>
			</div>
			<div class="aui-scroll-content">
				<div class="tab_box">
				<?php
				foreach ($categoryArray as $key => $value) {
					echo '<div class="category_'.$value.'">';
					$list = $newProductList[$value];
					foreach ($list as $product) {
						echo '<div class="am-g am-intro-bd">';
							echo '<div class="am-intro-left am-u-sm-10">';
								echo '<a href="'.$baseHost.'ui-product.phtml?productId='.$product['product_id'].'">';
								#<img class="lazy" src="grey.gif" data-original="example.jpg" width="640" heigh="480">min-width: 72px; max-width: 100%; width: auto; height: auto;
									echo '<div class="am-intro-left am-u-sm-4"><div class="class_img_box"><img  class="lazy" src="./images/grey.gif" data-original="'.smallImage($product['image']).'" /></div></div>';
									echo '<div class="am-intro-right am-u-sm-8"><div style="padding-left:10px;">';
										echo '<h2>'.$product['name'].'</h2>';
										echo '<p>'.$product['short_description'];
										if (count($product['tier_price']) > 0) {
											$special_price = $product['tier_price'][0];
											echo '(';
											echo '购买'.round($special_price['price_qty'],0).'件低至$'.round($special_price['price'],2);
											echo ')';
										}
										echo '</p>';
										echo '<div class="text">';
											if (!is_null($product['special_price'])) {
												echo '<span class="fl">CA$&nbsp;&nbsp;'.round($product['special_price'], 2).'</span>';
												echo '<span class="aui-list-product-item-del-price">';
												echo 'CA$'.number_format($product['price'],2);
												echo '</span>	';
											}else{
												echo '<span class="fl">CA$&nbsp;&nbsp;'.round($product['price'], 2).'</span>';
											}
										echo '</div>';
									echo '</div></div>';
								echo '</a>';
							echo '</div>';

							echo '<div class="am-intro-right am-u-sm-1" onclick="addToCart(\''.$cartId.'\',\''.$product['product_id'].'\')">';
								echo '<span class="fr add-to-car-button"><img src="themes/img/icon/icon-kin.png"/></span>';
							echo '</div>';
						echo '</div>';
					}
					echo '</div>';
				}
				?>
				</div>
<!-- 				<div class="am-g am-intro-bd">
		    	<a href="#">
			        <div class="am-intro-left am-u-sm-3"><img src="themes/img/pd/sf-2.jpg"  /></div>
			        <div class="am-intro-right am-u-sm-8">
			        	<h2>芝士威化饼干</h2>
			        	<p>290gx1盒</p>
			        	<div class="text">
			        		<span class="fl">￥10.8</span>
			        		<span class="fr"><img src="themes/img/icon/icon-kin.png"  /></span>
			        	</div>
			        </div>
		       	</a>
		    	</div> -->
			</div>
		</div>
	</section>


	<footer class="aui-footer-default aui-footer-fixed">
		<a href="index.phtml" class="aui-footer-item ">
			<span class="aui-footer-item-icon aui-icon aui-footer-icon-home"></span>
			<span class="aui-footer-item-text">首页</span>
		</a>
		<a href="class.phtml" class="aui-footer-item aui-footer-active">
			<span class="aui-footer-item-icon aui-icon aui-footer-icon-class"></span>
			<span class="aui-footer-item-text">分类</span>
		</a>
		<!-- <a href="find.html" class="aui-footer-item">
			<span class="aui-footer-item-icon aui-icon aui-footer-icon-find"></span>
			<span class="aui-footer-item-text">发现</span>
		</a> -->
		<a href="car.phtml" class="aui-footer-item">
			<span class="aui-footer-item-icon aui-icon aui-footer-icon-car"></span>
			<span class="aui-footer-item-text">购物车</span>
		</a>
		<a href="ui-me.phtml" class="aui-footer-item">
			<span class="aui-footer-item-icon aui-icon aui-footer-icon-me"></span>
			<span class="aui-footer-item-text">我的</span>
		</a>
	</footer>

	<script src="themes/js/jquery.min.js"></script>
	<script src="themes/js/aui.js"></script>
	<script src="themes/js/jquery.lazyload.js"></script>
	<script src="themes/js/jquery.scrollstop.js"></script>
</body>
<script type="text/javascript">
	function GetQueryString(name)
	{
		var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
		var r = window.location.search.substr(1).match(reg);
		if (r != null) {
        return unescape(r[2]);
    	} 
    	return null;
	}

	window.onbeforeunload=function(){
    	sessionStorage.setItem("bdbbuy-offsetTop",$(".aui-scroll-content").scrollTop());
	}

	window.onload = function(){
		var index = sessionStorage.getItem("bdbbuy-class-index");
		if (index == null) {index = 0};
		var lis = $('.tab_menu')[0].children[0].children;
		if (lis.length >= index) {
			$(lis[index]).addClass("on").siblings().removeClass("on");
			$(".tab_box > div").eq(index).show().siblings().hide();
		};
		 $('img').lazyload({
			event: 'scrollstop'
		 });
		var _offset = sessionStorage.getItem("bdbbuy-offsetTop");
		$(".aui-scroll-content").scrollTop(_offset);
	};

	$(function(){
		$(".tab_menu ul li").click(function(){
			 $(this).addClass("on").siblings().removeClass("on"); //切换选中的按钮高亮状态
			 var index=$(this).index(); //获取被按下按钮的索引值，需要注意index是从0开始的
			 sessionStorage.setItem("bdbbuy-class-index",index);
			 $(".tab_box > div").eq(index).show().siblings().hide(); //在按钮选中时在下面显示相应的内容，同时隐藏不需要的框架内容
			 $(".aui-scroll-content").scrollTop(0);
			 $('img').lazyload({
				event: 'scrollstop'
			 });
		 });
		if (GetQueryString('category_id') != null) {
			var index = $(".category_" + GetQueryString("category_id")).index();
			$(".tab_menu ul").find("li:eq("+index+")").click();
		};
		$(".aui-scroll-content").scroll(function() {
			$('img').lazyload({
				event: 'scrollstop'
			});
		});
		$('img').lazyload({
			event: 'scrollstop'
		});
	});

	function addToCart(cartId,productId) { 

        // $('#loading').showLoading();

		swal({
			  title: "",
			  text: "正在添加",
			  onOpen:()=>{swal.showLoading()}
			});

        $.ajax({  

            url:"<?php echo $baseHost ?>cart.php?addToCart="+cartId+"&productId="+productId,           

            type: "GET",         

            success:function(result){  
            	if (result != "true") {
					swal({
					  // position: 'top-end',
					  type: 'error',
					  title: '加入失败',
					  showConfirmButton: false,
					  timer: 1500
					})
            	}else{
					swal({
					  // position: 'top-end',
					  type: 'success',
					  title: '加入成功',
					  showConfirmButton: false,
					  timer: 1500
					})
            	};

            },

            error:function(XMLHttpRequest, textStatus, errorThrown){
            		swal({
					  title: "",
					  text: "加入失败",
					  icon: "error",
					  button: false,
					  timer: 1300,
					});
                // $('#loading').hideLoading();

            }

        });

    }

</script>
</html>