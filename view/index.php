<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="pragma" content="public" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui"/>
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
	<meta name="format-detection" content="telephone=no, email=no"/>
	<meta charset="UTF-8">
	<title>八点半买</title>
	<link rel="stylesheet" type="text/css" href="themes/css/core.css">
	<link rel="stylesheet" type="text/css" href="themes/css/icon.css">
	<link rel="stylesheet" type="text/css" href="themes/css/home.css">
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<link href="iTunesArtwork@2x.png" sizes="114x114" rel="apple-touch-icon-precomposed">
</head>
<?php 
include_once('../config.php');
require_once('../model/ProductModel.php');

$productModel = new ProductModel();

#水果
// $url1= $baseHost . 'productInfo.php?ids=5912-5983-5915-6039-6042-5920';
// $sgsx = json_decode(file_get_contents($url1),true);
$sgsx = $productModel->getProductInfoByIds('5912-5983-5915-6039-6042-5920');
#休闲零食
// $url2= $baseHost .'productInfo.php?ids=5884-5797-5495-6065-5744-5790';
// $xxls = json_decode(file_get_contents($url2),true);
$xxls = $productModel->getProductInfoByIds('5884-5797-5495-6065-5744-5790');
#坚果蜜饯
// $url3= $baseHost .'productInfo.php?ids=5051-5882-5880-5490-5485-5881';
// $jgmj = json_decode(file_get_contents($url3),true);
$jgmj = $productModel->getProductInfoByIds('5051-5882-5880-5490-5485-5881');
#个人护理
// $url4= $baseHost .'productInfo.php?ids=5707-5430-5951-5348-5341';
// $grhl = json_decode(file_get_contents($url4),true);
$grhl = $productModel->getProductInfoByIds('5707-5430-5951-5348-5341');
#推荐商品
// $url5= $baseHost .'productInfo.php?ids=5686-5689-5692-5790-5826-5838-5856-5880-5884-5886-5892';
// $tjsp = json_decode(file_get_contents($url5),true);
$tjsp = $productModel->getProductInfoByIds('5686-5689-5692-5790-5826-5838-5856-5880-5884-5886-5892');

?>
<body>

	<header class="aui-header-default aui-header-fixed aui-header-bg">
		<a href="#" class="aui-header-item"  style="display:none">
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
	<div class="aui-content-box">
		<div class="aui-banner-content aui-fixed-top" data-aui-slider>
			<div class="aui-banner-wrapper">
				<div class="aui-banner-wrapper-item index-banner">
					<a href="class.phtml?category_id=256">
						<img src="https://bdbbuy-mobile.oss-cn-hongkong.aliyuncs.com/banner/bg-s1-01.png">
					</a>
				</div>
				<div class="aui-banner-wrapper-item index-banner">
					<a href="#">
						<img src="https://bdbbuy-mobile.oss-cn-hongkong.aliyuncs.com/banner/bg-s2-01.png">
					</a>
				</div>
				<div class="aui-banner-wrapper-item index-banner">
					<a href="class.phtml?category_id=64">
						<img src="https://bdbbuy-mobile.oss-cn-hongkong.aliyuncs.com/banner/bg-s3-01.png">
					</a>
				</div>
				<div class="aui-banner-wrapper-item index-banner">
					<a href="class.phtml?category_id=122">
						<img src="https://bdbbuy-mobile.oss-cn-hongkong.aliyuncs.com/banner/bg-s4-01.png">
					</a>
				</div>
			</div>
			<div class="aui-banner-pagination"></div>
		</div>
		<section class="aui-grid-content">
			<div class="aui-grid-row" id="category">
				<a href="class.phtml?category_id=256" class="aui-grid-row-item"><i class="aui-icon-large aui-icon-256"></i><p class="aui-grid-row-label">生鲜水果</p></a>
				<a href="class.phtml?category_id=64" class="aui-grid-row-item"><i class="aui-icon-large aui-icon-64"></i><p class="aui-grid-row-label">休闲零食</p></a>
				<a href="class.phtml?category_id=79" class="aui-grid-row-item"><i class="aui-icon-large aui-icon-79"></i><p class="aui-grid-row-label">饼干糕点</p></a>
				<a href="class.phtml?category_id=92" class="aui-grid-row-item"><i class="aui-icon-large aui-icon-92"></i><p class="aui-grid-row-label">糖果巧克力</p></a>
				<a href="class.phtml?category_id=128" class="aui-grid-row-item"><i class="aui-icon-large aui-icon-128"></i><p class="aui-grid-row-label">坚果蜜饯</p></a>

				<a href="class.phtml?category_id=141" class="aui-grid-row-item"><i class="aui-icon-large aui-icon-141"></i><p class="aui-grid-row-label">粮油调味</p></a>
				<a href="class.phtml?category_id=135" class="aui-grid-row-item"><i class="aui-icon-large aui-icon-135"></i><p class="aui-grid-row-label">酒水饮料</p></a>
				<a href="class.phtml?category_id=113" class="aui-grid-row-item"><i class="aui-icon-large aui-icon-113"></i><p class="aui-grid-row-label">方便速食</p></a>
				<a href="class.phtml?category_id=122" class="aui-grid-row-item"><i class="aui-icon-large aui-icon-122"></i><p class="aui-grid-row-label">个人护理</p></a>
				<a href="class.phtml?category_id=163" class="aui-grid-row-item"><i class="aui-icon-large aui-icon-163"></i><p class="aui-grid-row-label">生活日用</p></a>

			</div>
		</section>
		<div class="aui-dri"></div>
		<div class="aui-list-content">
			<div class="aui-list-item">
				<div class="aui-list-item-img">
					<img src="https://bdbbuy-mobile.oss-cn-hongkong.aliyuncs.com/banner/banner-sgsx.png" alt="">
				</div>
				<div class="aui-slide-box">
					<div class="aui-slide-list">
						<ul class="aui-slide-item-list" id = "fruit">
							<?php 
								foreach ($sgsx as $product) {
									echo '<li class="aui-slide-item-item"><a href="ui-product.phtml?productId='.$product['product_id'].'" class="v-link">';
									echo '<div class="index_img_box"><img class="v-img" src="'.smallImage($product['image']).'"></div>';
									echo '<p class="aui-slide-item-title aui-slide-item-f-els">'.$product['name'].'</p>';
									echo '<p class="aui-slide-item-info"><span class="aui-slide-item-price"><em>CA$</em>'.round($product['price'],2).'</span></p>';
									echo '</a></li>';
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="aui-list-content">
			<div class="aui-list-item">
				<div class="aui-list-item-img">
					<img src="https://bdbbuy-mobile.oss-cn-hongkong.aliyuncs.com/banner/banner-xxls.png" alt="">
				</div>
				<div class="aui-slide-box">
					<div class="aui-slide-list">
						<ul class="aui-slide-item-list" id = "xxls">
							<?php 
								foreach ($xxls as $product) {
									echo '<li class="aui-slide-item-item"><a href="ui-product.phtml?productId='.$product['product_id'].'" class="v-link">';
									echo '<div class="index_img_box"><img class="v-img" src="'.smallImage($product['image']).'"></div>';
									echo '<p class="aui-slide-item-title aui-slide-item-f-els">'.$product['name'].'</p>';
									echo '<p class="aui-slide-item-info"><span class="aui-slide-item-price"><em>CA$</em>'.round($product['price'],2).'</span></p>';
									echo '</a></li>';
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="aui-list-content">
			<div class="aui-list-item">
				<div class="aui-list-item-img">
					<img src="https://bdbbuy-mobile.oss-cn-hongkong.aliyuncs.com/banner/banner-jgmj.png" alt="">
				</div>
				<div class="aui-slide-box">
					<div class="aui-slide-list">
						<ul class="aui-slide-item-list" id = "jgmj">
							<?php 
								foreach ($jgmj as $product) {
									echo '<li class="aui-slide-item-item"><a href="ui-product.phtml?productId='.$product['product_id'].'" class="v-link">';
									echo '<div class="index_img_box"><img class="v-img" src="'.smallImage($product['image']).'"></div>';
									echo '<p class="aui-slide-item-title aui-slide-item-f-els">'.$product['name'].'</p>';
									echo '<p class="aui-slide-item-info"><span class="aui-slide-item-price"><em>CA$</em>'.round($product['price'],2).'</span></p>';
									echo '</a></li>';
								}
							?>

						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="aui-list-content">
			<div class="aui-list-item">
				<div class="aui-list-item-img">
					<img src="https://bdbbuy-mobile.oss-cn-hongkong.aliyuncs.com/banner/banner-grhl.png" alt="">
				</div>
				<div class="aui-slide-box">
					<div class="aui-slide-list">
						<ul class="aui-slide-item-list" id = "grhl">
							<?php 
								foreach ($grhl as $product) {
									echo '<li class="aui-slide-item-item"><a href="ui-product.phtml?productId='.$product['product_id'].'" class="v-link">';
									echo '<div class="index_img_box"><img class="v-img" src="'.smallImage($product['image']).'"></div>';
									echo '<p class="aui-slide-item-title aui-slide-item-f-els">'.$product['name'].'</p>';
									echo '<p class="aui-slide-item-info"><span class="aui-slide-item-price"><em>CA$</em>'.round($product['price'],2).'</span></p>';
									echo '</a></li>';
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>


		<div class="aui-recommend">
			<img src="themes/img/bg/icon-tj1.jpg" alt="">
		</div>
		<section class="aui-list-product">
			<div class="aui-list-product-box" id = "recommend">
						<?php 
							foreach ($tjsp as $product) {
								echo '<a href="ui-product.phtml?productId='.$product['product_id'].'" class="aui-list-product-item">';
								echo '<div class="aui-list-product-item-img">';
								echo '<div class="index_img_box"><img class="v-img" src="'.smallImage($product['image']).'"></div>';
								echo '</div>';
								echo '<div class="aui-list-product-item-text">';
									echo '<h3>'.$product['name'].'</h3>';
									echo '<div class="aui-list-product-mes-box"><div><span class="aui-list-product-item-price"><em>CA$</em>'.round($product['price'],2).'</span></div></div>';
								echo '</div></a>';
							}
						?>
			</div>
		</section>
	</div>

	<footer class="aui-footer-default aui-footer-fixed">
		<a href="index.phtml" class="aui-footer-item aui-footer-active">
			<span class="aui-footer-item-icon aui-icon aui-footer-icon-home"></span>
			<span class="aui-footer-item-text">首页</span>
		</a>
		<a href="index.php?c=Category&a=toCategoryView" class="aui-footer-item">
			<span class="aui-footer-item-icon aui-icon aui-footer-icon-class"></span>
			<span class="aui-footer-item-text">分类</span>
		</a>
<!-- 		</a>
	 		<a href="find.html" class="aui-footer-item">
			<span class="aui-footer-item-icon aui-icon aui-footer-icon-find"></span>
			<span class="aui-footer-item-text">发现</span>
		</a>  -->
		<a href="car.phtml" class="aui-footer-item">
			<span class="aui-footer-item-icon aui-icon aui-footer-icon-car"></span>
			<span class="aui-footer-item-text">购物车</span>
		</a>
		<?php
		include_once('../model/UserModel.php');
		$userModel = new UserModel();
		$userid = $userModel->userid();
		if (is_null($userid)) {
			echo '<a href="login.html" class="aui-footer-item">';
			
		}else{
			echo '<a href="ui-me.phtml" class="aui-footer-item">';
		}
		?>
			<span class="aui-footer-item-icon aui-icon aui-footer-icon-me"></span>
			<span class="aui-footer-item-text">我的</span>
		</a>
	</footer>
	<script type="text/javascript" src="themes/js/jquery.min.js"></script>
	<script type="text/javascript" src="themes/js/aui.js"></script>
</body>

</html>