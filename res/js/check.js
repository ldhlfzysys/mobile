/**
 * 数据校验JS
 */

//验证是否是IP地址
function isIP(strIP) {

	if (isNull(strIP)) {
		return false;
	}
	//匹配IP地址的正则表达式 
	var re = /^(\d+)\.(\d+)\.(\d+)\.(\d+)$/g;
	if (re.test(strIP)) {
		if (RegExp.$1 < 256 && RegExp.$2 < 256 && RegExp.$3 < 256
				&& RegExp.$4 < 256) {
			return true;
		}
	}
	return false;
}

/**
 * @param str
 * @returns true 标识为空
 * 检查字符串是否为空或者空格
 */
function isNull(str) {
	if (str == ""){
		return true;
	}
	var regu = "^[ ]+$";
	var re = new RegExp(regu);
	return re.test(str);
}

//检查两个字符串是否相等，相等返回 true
function ifEquals(str1,str2) {
	if (str1==str2) {
		return true;
	} else {
		return false;
	}
}

//验证是否为整数，包括负数
function isInteger(str) {
	var regu = /^[-]{0,1}[0-9]{1,}$/;
	return regu.test(str);
}

//验证是否为手机号,13,14,15,17,18开头
function checkMobile(s) {
	var regu = /^[1][3,4,5,7,8][0-9]{9}$/;
	var re = new RegExp(regu);
	if (re.test(s)) {
		return true;
	} else {
		return false;
	}
}

//判断是否为正整数
function isNumber(s) {
	var regu = "^[0-9]+$";
	var re = new RegExp(regu);
	if (s.search(re) != -1) {
		return true;
	} else {
		return false;
	}
}

//检查是否是小数，可以是负数
function isDecimal(str) {
	if (isInteger(str)) {
		return false;
	}
	var re = /^[-]{0,1}(\d+)[\.]+(\d+)$/;
	if (re.test(str)) {
		return true;
	} else {
		return false;
	}
}

//检查是否为邮箱格式
function isEmail(str) {
	var myReg = /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/;
	if (myReg.test(str)) {
		return true;
	} else {
		return false;
	}

}

//判断是否金额，保留小数两位的整数
function isMoney(s) {
	var regu = "^[0-9]+[\.][0-9]{2,2}$";
	var re = new RegExp(regu);
	if (re.test(s)) {
		return true;
	} else {
		return false;
	}
}

//判断是否是数字或字母 
function isNumberOrLetter(s) {
	var regu = "^[0-9a-zA-Z]+$";
	var re = new RegExp(regu);
	if (re.test(s)) {
		return true;
	} else {
		return false;
	}
}

//检查是否为url路径
function isUrl(str) {
	var reg = /^(http\:\/\/)?([a-z0-9][a-z0-9\-]+\.)?[a-z0-9][a-z0-9\-]+[a-z0-9](\.[a-z]{2,4})+(\/[a-z0-9\.\,\-\_\%\?\=\&]?)?$/i;
	return reg.test(str);
}

//判断是否包含汉字
function contentWord(str) {
	if (escape(str).indexOf("%u") != -1) {
		return true;
	} else {
		return false;
	}
}
//去掉字符串中所有空格(包括中间空格,需要设置第2个参数为:g)
function trim(str,is_global){
    var result;
    result = str.replace(/(^\s+)|(\s+$)/g,"");
    if(is_global.toLowerCase()=="g")
    {
        result = result.replace(/\s/g,"");
     }
    return result;
}

//获取字符串长度，汉字两个字符，字母一个字符
function getByteLen(val) {
    var len = 0;
    for (var i = 0; i < val.length; i++) {
        var a = val.charAt(i);
        if (a.match(/[^\x00-\xff]/ig) != null) {
            len += 2;
        }
        else {
            len += 1;
        }
    }
    return len;
}
//定义一个全国地区的对象
var aCity={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"}; 
//身份证号检验
function isCardID(sId){
	 var iSum=0 ;
	 if(!/^\d{17}(\d|x)$/i.test(sId)) return "你输入的身份证长度或格式错误";
	 sId=sId.replace(/x$/i,"a");
	 if(aCity[parseInt(sId.substr(0,2))]==null) return "你的身份证地区非法";
	 sBirthday=sId.substr(6,4)+"-"+Number(sId.substr(10,2))+"-"+Number(sId.substr(12,2));
	 var d=new Date(sBirthday.replace(/-/g,"/")) ;
	 if(sBirthday!=(d.getFullYear()+"-"+ (d.getMonth()+1) + "-" + d.getDate()))return "身份证上的出生日期非法";
	 for(var i = 17;i>=0;i --) iSum += (Math.pow(2,i) % 11) * parseInt(sId.charAt(17 - i),11) ;
	 if(iSum%11!=1) return "你输入的身份证号非法";
	 //aCity[parseInt(sId.substr(0,2))]+","+sBirthday+","+(sId.substr(16,1)%2?"男":"女");//此次还可以判断出输入的身份证号的人性别
	 return true;
}

//数组转换JSON
function arrayToJson(o) {
    var r = [];
    if (typeof o == "string") return "\"" + o.replace(/([\'\"\\])/g, "\\$1").replace(/(\n)/g, "\\n").replace(/(\r)/g, "\\r").replace(/(\t)/g, "\\t") + "\"";
    if (typeof o == "object") {
      if (!o.sort) {
        for (var i in o)
          r.push(i + ":" + arrayToJson(o[i]));
        if (!!document.all && !/^\n?function\s*toString\(\)\s*\{\n?\s*\[native code\]\n?\s*\}\n?\s*$/.test(o.toString)) {
          r.push("toString:" + o.toString.toString());
        }
        r = "{" + r.join() + "}";
      } else {
        for (var i = 0; i < o.length; i++) {
          r.push(arrayToJson(o[i]));
        }
        r = "[" + r.join() + "]";
      }
      return r;
    }
    return o.toString();
}

//银行卡号Luhn校验算法
//luhn校验规则：16位银行卡号（19位通用）: 
//1.将未带校验位的 15（或18）位卡号从右依次编号 1 到 15（18），位于奇数位号上的数字乘以 2。
//2.将奇位乘积的个十位全部相加，再加上所有偶数位上的数字。
//3.将加法和加上校验位能被 10 整除。

//bankno为银行卡号
 function luhnCheck(bankno){
     var lastNum=bankno.substr(bankno.length-1,1);//取出最后一位（与luhn进行比较）
 
     var first15Num=bankno.substr(0,bankno.length-1);//前15或18位
     var newArr=new Array();
     for(var i=first15Num.length-1;i>-1;i--){    //前15或18位倒序存进数组
         newArr.push(first15Num.substr(i,1));
     }
     var arrJiShu=new Array();  //奇数位*2的积 <9
     var arrJiShu2=new Array(); //奇数位*2的积 >9
     
     var arrOuShu=new Array();  //偶数位数组
     for(var j=0;j<newArr.length;j++){
         if((j+1)%2==1){//奇数位
             if(parseInt(newArr[j])*2<9)
             arrJiShu.push(parseInt(newArr[j])*2);
             else
             arrJiShu2.push(parseInt(newArr[j])*2);
         }
         else //偶数位
         arrOuShu.push(newArr[j]);
     }
     
     var jishu_child1=new Array();//奇数位*2 >9 的分割之后的数组个位数
     var jishu_child2=new Array();//奇数位*2 >9 的分割之后的数组十位数
     for(var h=0;h<arrJiShu2.length;h++){
         jishu_child1.push(parseInt(arrJiShu2[h])%10);
         jishu_child2.push(parseInt(arrJiShu2[h])/10);
     }        
     
     var sumJiShu=0; //奇数位*2 < 9 的数组之和
     var sumOuShu=0; //偶数位数组之和
     var sumJiShuChild1=0; //奇数位*2 >9 的分割之后的数组个位数之和
     var sumJiShuChild2=0; //奇数位*2 >9 的分割之后的数组十位数之和
     var sumTotal=0;
     for(var m=0;m<arrJiShu.length;m++){
         sumJiShu=sumJiShu+parseInt(arrJiShu[m]);
     }
     
     for(var n=0;n<arrOuShu.length;n++){
         sumOuShu=sumOuShu+parseInt(arrOuShu[n]);
     }
     
     for(var p=0;p<jishu_child1.length;p++){
         sumJiShuChild1=sumJiShuChild1+parseInt(jishu_child1[p]);
         sumJiShuChild2=sumJiShuChild2+parseInt(jishu_child2[p]);
     }      
     //计算总和
     sumTotal=parseInt(sumJiShu)+parseInt(sumOuShu)+parseInt(sumJiShuChild1)+parseInt(sumJiShuChild2);
     
     //计算luhn值
     var k= parseInt(sumTotal)%10==0?10:parseInt(sumTotal)%10;        
     var luhn= 10-k;
     
     if(lastNum==luhn){
        // console.log("验证,通过");
         return true;
     }else{
        // layer.msg("银行卡号必,须符合luhn校验");
         return false;
     }        
 }
 
 //检查银行卡号
 function CheckBankNo(bankno) {
     var bankno = bankno.replace(/\s/g,'');
     if(bankno == "") {
         // layer.msg("请填写银行卡号");
         return false;
     }
     if(bankno.length < 16 || bankno.length > 19) {
         // layer.msg("银行卡号长度必须在16到19之间");
         return false;
     }
     var num = /^\d*$/;//全数字
     if(!num.exec(bankno)) {
         // layer.msg("银行卡号必须全为数字");
         return false;
     }
     //开头6位
     var strBin = "10,18,30,35,37,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,58,60,62,65,68,69,84,87,88,94,95,98,99";
     if(strBin.indexOf(bankno.substring(0, 2)) == -1) {
         // layer.msg("银行卡号开头6位不符合规范");
         return false;
     }
     //Luhn校验
     if(!luhnCheck(bankno)){
         return false;
     }
     return true;
 }