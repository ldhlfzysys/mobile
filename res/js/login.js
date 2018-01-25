function login(){
	var userID = $("#userid").val();
	var password =  $("#password").val();

	// 校验数据
	if (isNull(userID) || isNull(password)) {
        alert("请输入账户或密码");
        return;
    }
	$.ajax({  
        url:"http://bdbbuy.com/mobile/login.php",  
        type: "POST",
        data:{userid:userID,password:password},         
        success:function(result){  

        	var res = eval("(" + result + ")");
            // console.log(res)
            if (res['status'] == 'OK') {
            	var nickname = res['userData']['firstname']+' '+res['userData']['lastname'];
            	document.cookie="bdb-ui="+res['userData']['customer_id'];
            	document.cookie="bdb-nn="+nickname;
            	window.location.href='http://bdbbuy.com/mobile/ui-me.phtml';
            }else{
            	document.location.reload();
            }
        },
        error:function(XMLHttpRequest, textStatus, errorThrown){
        }

    });
}