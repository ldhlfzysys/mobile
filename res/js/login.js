function login(){
	var userID = $("#userid").val();
	var password =  $("#password").val();

	// 校验数据
	if (isNull(userID) || isNull(password)) {
        alert("请输入账户或密码");
        return;
    }
    $.showLoading("正在登陆...");
	$.ajax({  
        url:baseHost + "login.php",  
        type: "POST",
        data:{userid:userID,password:password},         
        success:function(result){  
            $.hideLoading();
        	var res = eval("(" + result + ")");
            // console.log(res)
            if (res['status'] == 'OK') {
            	var nickname = res['userData']['firstname']+' '+res['userData']['lastname'];
            	document.cookie="bdb-ui="+res['userData']['customer_id'];
            	document.cookie="bdb-nn="+nickname;
            	window.location.href=baseHost + 'ui-me.phtml';
            }else{
            	// document.location.reload();
                $.toast("账户或者密码错误","text");
            }
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $.hideLoading();
            $.toast("登录失败","text");
        }
    });
}