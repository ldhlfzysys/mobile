$(function () {
 	// 设置初始订单
 	var orderStatus = $("#orderStatus").val();
 	tabClick(orderStatus);
});
// tab点击
function tabClick(status){
	for (var i = 1; i < 5; i++) {
		var item = $("#order" + i);
		var tab = $("#tab" + i);
		item.removeClass('tab-active');
		tab.removeClass('tab-active');
		if(status == i){
			item.addClass("tab-active");
			tab.addClass('tab-active');
		}
	}
}

