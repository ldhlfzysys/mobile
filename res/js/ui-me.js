
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
});