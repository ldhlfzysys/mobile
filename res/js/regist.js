

// 账户注册
function regist(){
    var firstName = $('#firstName').val();
	var lastName = $('#lastName').val();
    var email = $('#email').val();
    var password1 = $('#password1').val();
    var password2 = $('#password2').val();
	
    if (isNull(firstName) || isNull(lastName) || isNull(password1) || isNull(password2)) {
        alert("请将信息填写完整");
        return;
    }

    if (password1 != password2) {
        alert("两次密码输入不一致");
        return;
    }

    if (!isEmail(email)) {
        alert("邮箱格式错误");
        return;
    }

	$.ajax({  
        url:"http://bdbbuy.com/mobile/regist.php",           
        type: "POST",
        data:{"firstName":firstName,"lastName":lastName,"email":email,"password":password1},         
        success:function(result){  
        	var res = eval("(" + result + ")");
            console.log(res)
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            alert("注册失败");
        }
    });
}