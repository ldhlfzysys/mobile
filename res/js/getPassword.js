
// 发送激活邮件
function sendEmail(){
	var email = $("#email").val();

	// 校验数据
	if (!isEmail(email)) {
        $.toast("邮箱格式错误","text");
        return;
    }
    $.showLoading("正在发送...");
	$.ajax({  
        url: baseHost + "aliyunEmail.php",  
        type: "POST",
        data:{email:email,sendEmail:true},         
        success:function(result){  
            $.hideLoading();
            var res = eval("(" + result + ")");
            if (res['status'] == 0) {
                $.toast("发送成功");
                setTimeout(function(){
                    window.location.href=baseHost + 'index.phtml';
                },1000);
            }else{
                $.alert(res['msg']);
            }
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $.hideLoading();
            $.alert("请求失败，稍后再试");
        }
    });
}