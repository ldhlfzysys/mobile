function basename(str1)
{
   str2="/"
   
   var s = str1.lastIndexOf(str2);
   if (s==-1) {
   str2="\\"
   var s = str1.lastIndexOf(str2);
   }
   if (s==-1) alert("字符串非法")
   else{
    return(str1.substring(s+1,str1.length));
   }
   return ""
}

$(function () {
    //绑定滚动条事件
    $(window).bind("scroll", function () {
        var sTop = $(window).scrollTop();
        var sTop = parseInt(sTop);
        if (sTop >= 44) {
            if (!$("#scrollSearchDiv").is(":visible")) {
                try {
                    $("#scrollSearchDiv").slideDown();
                } catch (e) {
                    $("#scrollSearchDiv").show();
                }
            }
        }
        else {
            if ($("#scrollSearchDiv").is(":visible")) {
                try {
                    $("#scrollSearchDiv").slideUp();
                } catch (e) {
                    $("#scrollSearchDiv").hide();
                }
            }
        }
    });

    // 请求精选推荐商品信息
	recommend_lists = ['5686', '5689', '5692', '5790', '5826', '5838', '5856', '5862', '5880', '5884', '5886', '5892'];
	ids = recommend_lists.join('-');
	$.get('http://bdbbuy.com/mobile/productInfo.php?ids=' + ids, function(data){
        // console.log(data);
		var results = eval("(" + data + ")");
		for(var i = 0; i < results.length; i ++){
			var res = results[i];
			var id = res['product_id'];
			var name = res['name'];
			var price = res['price'];
			var url = 'http://bdbbuy-mobile.oss-cn-hongkong.aliyuncs.com/' + basename(res['image']) +'?x-oss-process=style/center';
			var str = '<a href="ui-product.phtml?productId='+id+'" class="aui-list-product-item"><div class="aui-list-product-item-img"><img src="' + url + '" alt=""></div><div class="aui-list-product-item-text"><h3>' + name + '</h3><div class="aui-list-product-mes-box"><div><span class="aui-list-product-item-price"><em>CA$</em>' + price.substr(0,price.indexOf(".")+3) + '</span></div></div></div></a>';
			//<span class="aui-list-product-item-del-price"><em>$</em>' + special_price + '</span>
			$("#recommend").append(str);
		}
	});
});