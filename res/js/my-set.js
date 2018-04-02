//读取cookies 
function getCookie(name) 
{ 
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");

	if(arr=document.cookie.match(reg))

	    return unescape(arr[2]); 
	else 
	    return null; 
} 

//删除cookies 
function delCookie(name) 
{ 
	var exp = new Date(); 
	exp.setTime(exp.getTime() - 1); 
	var cval=getCookie(name); 
	if(cval!=null) 
	    document.cookie= name + "="+cval+";expires="+exp.toGMTString(); 
}

function logout(){
	delCookie('bdb-ui');
	delCookie('bdb-nn');
	window.location.href=baseHost + 'index.phtml';
}

// 弹出密码输入框
function alertSet(){
	$.modal({
	  title: "重置密码",
	  text: "<input class = 'weui-input weui-prompt-input' type = 'password' id = 'password1' placeholder='输入新密码' />"
	  +"<input class = 'weui-input weui-prompt-input' type = 'password' id = 'password2' placeholder='再次输入新密码'/>",
	  buttons: [
	  	{ text: "取消", className: "default", onClick: function(){ $.closeModal();} },
	    { text: "确认", onClick: function(){ resetPassword()} },
	  ]
	});
}

// 重置密码
function resetPassword(){
	var password1 = $("#password1").val();
	var password2 = $("#password2").val();

	if (password1 == undefined || password2 == undefined || password1 == "" || password2 == "") {
		$.alert("请输入密码");
		return;
	}
	if (password1 != password2) {
		$.alert("两次密码输入不一致");
		return;
	}
	// $.toast(password1,"text");

	// 执行密码修改
	$.showLoading("正在修改...");
	$.ajax({  
        url:baseHost + "user.php",  
        type: "POST",
        data:{resetPassword:"resetPassword",password:password1},         
        success:function(result){  
            $.hideLoading();
            var res = eval("(" + result + ")");
        	if (res['status'] == 0) {
        		setTimeout(function(){
        			logout();
        		},1000)
        	}
        	$.toast(res['msg']);
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $.hideLoading();
            $.toast("修改失败","text");
        }
    });
}














