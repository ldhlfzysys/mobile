
//生成从minNum到maxNum的随机数
function randomNum(minNum,maxNum){ 
    switch(arguments.length){ 
        case 1: 
            return parseInt(Math.random()*minNum+1,10); 
        break; 
        case 2: 
            return parseInt(Math.random()*(maxNum-minNum+1)+minNum,10); 
        break; 
            default: 
                return 0; 
            break; 
    } 
}

// 账户注册
function regist(){
    var firstName = '用户';
	var lastName = randomNum(9999,99999999);
    var email = $('#email').val();
    var password1 = $('#password1').val();
    var password2 = $('#password2').val();
	
    if (isNull(firstName) || isNull(lastName) || isNull(password1) || isNull(password2)) {
        // alert("请将信息填写完整");
        $.toast("请将信息填写完整","text");
        return;
    }

    if (password1 != password2) {
        // alert("两次密码输入不一致");
        $.toast("两次密码输入不一致","text");
        return;
    }

    if (!isEmail(email)) {
        // alert("邮箱格式错误");
        $.toast("邮箱格式错误","text");
        return;
    }
    $.showLoading("正在注册...");
	$.ajax({  
        url:"https://m.bdbbuy.com/regist.php",           
        type: "POST",
        data:{"firstName":firstName,"lastName":lastName,"email":email,"password":password1},         
        success:function(result){  
            $.hideLoading();
        	var res = eval("(" + result + ")");
            // console.log(res)
            if(res.status == 0){
                var nickname = firstName+' '+lastName;
                document.cookie="bdb-ui="+res.data;
                document.cookie="bdb-nn="+nickname;
                window.location.href='https://m.bdbbuy.com/ui-me.phtml';
            }else{
                // alert(res.msg);
                $.toast(res.msg,"text");
            }
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
            $.hideLoading();
            // alert("注册失败");
            $.toast("注册失败","text");
        }
    });
}