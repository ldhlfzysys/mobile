
// 重置密码
function resetPassword(){
	var password1 = $("#password1").val();
    var password2 = $("#password2").val();

    if (isNull(password1) || isNull(password2)) {
        $.alert("请输入密码");
        return;
    }
    if (password1 != password2) {
        $.alert("两次密码输入不一致");
        return;
    }
    var userid = $("#userid").val();
    var tocken = $("#tocken").val();

    if (isNull(userid) || isNull(tocken)) {
        $.alert("无效的链接地址");
        return;
    }

    $.showLoading("正在操作...");
	$.ajax({  
        url: baseHost + "user.php",  
        type: "POST",
        data:{getPassword:true,password:password1,userid:userid,tocken:tocken},         
        success:function(result){  
            $.hideLoading();
            var res = eval("(" + result + ")");
            if (res['status'] == 0) {
                setTimeout(function(){
                    window.location.href=baseHost + 'login.html';
                },1000);
            }
            $.toast(res['msg']);
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $.hideLoading();
            $.alert("请求失败，稍后再试");
        }
    });
}