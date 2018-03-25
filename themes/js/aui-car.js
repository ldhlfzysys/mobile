$(function(){
  // 数量减
  $(".minus").click(function() {
    var t = $(this).parent().find('.num');
    var qty = parseInt(t.text());
    var productid = $(this).parent().find('.min_prodcut_id').text();
    var cartid = $(this).parent().find('.cart_id').text();
    t.text(parseInt(t.text()) - 1);
    if (t.text() <= 0) {
        var datas = [];
        var dict = {};
        dict.product_id = productid;
        dict.qty = qty;
        datas.push(dict);
        var str = JSON.stringify(datas);
        var result = deleteProduct(cartid,str,productid);
        if (!result) {
          t.text(parseInt(t.text()) + 1);
        };
    }else{
      updatecart2(cartid);
    }
    // TotalPrice();
  });

  function deleteProduct(cartid,json_str,productid){
    $.showLoading("正在删除...");
     $.ajax({  
          url: baseHost + "cart.php?cartid="+cartid+"&remove="+json_str,           
          type: "GET",         
          success:function(result){  
              $.hideLoading();
              // alert(result);
              $("#item_"+productid).remove(); 
              document.location.reload();
          },
          error:function(XMLHttpRequest, textStatus, errorThrown){
              // $('#loading').hideLoading();
              // document.location.reload();
              $.toast("删除失败", "text");
          }
      });
     return true;
    // var r=confirm("删除该商品？");
    // if (r==true) {
    //         $.ajax({  
    //             url: baseHost + "cart.php?cartid="+cartid+"&remove="+json_str,           
    //             type: "GET",         
    //             success:function(result){  
    //                 // $('#loading').hideLoading();
    //                 // alert(result);
    //                 document.location.reload(); 
    //             },
    //             error:function(XMLHttpRequest, textStatus, errorThrown){
    //                 // $('#loading').hideLoading();
    //                 document.location.reload();
    //             }
    //         });
    //         return true;
    // }
    // return false;
  }

 function updatecart2(cartid) { 

    var datas = [];
      $(".aui-car-box").each(function() { //循环每个店铺
        $(this).find(".goodsCheck").each(function() { //循环店铺里面的商品
            var num = parseInt($(this).parents(".aui-car-box-list-item").find(".num").text()); //得到商品的数量
            var productid = parseFloat($(this).parents(".aui-car-box-list-item").find(".prodcut_id").text()); 
            var dict = {};
            dict.product_id = productid;
            dict.qty = num;
            datas.push(dict);
        });
      });
      if (datas.length == 0) {
        // alert('购物车空空，去添加商品吧~');
        $.toast("购物车空空，去添加商品吧~","text");
        return;
      };
      var str = JSON.stringify(datas);
      $.showLoading("正在操作...");
      $.ajax({  
          url:baseHost + "cart.php?cartid="+cartid+"&updateCart="+str,           
          type: "GET",         
          success:function(result){  
            $.hideLoading();
            if (result == "true") {
              document.location.reload(); 
            }else{
              alert('网络错误，请重试');
            };
              // $('#loading').hideLoading();
              // document.location.reload(); 
          },
          error:function(XMLHttpRequest, textStatus, errorThrown){
              // $('#loading').hideLoading();
              $.hideLoading();
              alert('网络错误，请重试');
          }
      });
    }


  // 数量加
  $(".plus").click(function() {
    var t = $(this).parent().find('.num');
    t.text(parseInt(t.text()) + 1);
    if (t.text() <= 1) {
      t.text(1);
    }
    var cartid = $(this).parent().find('.cart_id').text();
    updatecart2(cartid);
    // TotalPrice();
  });
  /******------------分割线-----------------******/
    // 点击商品按钮
  $(".goodsCheck").click(function() {
    var goods = $(this).closest(".aui-car-box").find(".goodsCheck"); //获取本店铺的所有商品
    var goodsC = $(this).closest(".aui-car-box").find(".goodsCheck:checked"); //获取本店铺所有被选中的商品
    var Shops = $(this).closest(".aui-car-box").find(".shopCheck"); //获取本店铺的全选按钮
    if (goods.length == goodsC.length) { //如果选中的商品等于所有商品
      Shops.prop('checked', true); //店铺全选按钮被选中
      if ($(".shopCheck").length == $(".shopCheck:checked").length) { //如果店铺被选中的数量等于所有店铺的数量
        $("#AllCheck").prop('checked', true); //全选按钮被选中
        TotalPrice();
      } else {
        $("#AllCheck").prop('checked', true); //else全选按钮不被选中
        TotalPrice();
      }
    } else { //如果选中的商品不等于所有商品
      Shops.prop('checked', true); //店铺全选按钮不被选中
      $("#AllCheck").prop('checked', true); //全选按钮也不被选中
      // 计算
      TotalPrice();
      // 计算
    }
  });
  // 点击店铺按钮
  $(".shopCheck").click(function() {
    if ($(this).prop("checked") == true) { //如果店铺按钮被选中
      $(this).parents(".aui-car-box").find(".goods-check").prop('checked', true); //店铺内的所有商品按钮也被选中
      if ($(".shopCheck").length == $(".shopCheck:checked").length) { //如果店铺被选中的数量等于所有店铺的数量
        $("#AllCheck").prop('checked', true); //全选按钮被选中
        TotalPrice();
      } else {
        $("#AllCheck").prop('checked', true); //else全选按钮不被选中
        TotalPrice();
      }
    } else { //如果店铺按钮不被选中
      $(this).parents(".aui-car-box").find(".goods-check").prop('checked', false); //店铺内的所有商品也不被全选
      $("#AllCheck").prop('checked', false); //全选按钮也不被选中
      TotalPrice();
    }
  });
  // 点击全选按钮
  $("#AllCheck").click(function() {
    if ($(this).prop("checked") == true) { //如果全选按钮被选中
      $(".goods-check").prop('checked', true); //所有按钮都被选中
      TotalPrice();
    } else {
      $(".goods-check").prop('checked', false); //else所有按钮不全选
      TotalPrice();
    }
    $(".shopCheck").change(); //执行店铺全选的操作
  });
  //计算
  function TotalPrice() {
    var allprice = 0; //总价
    $(".aui-car-box").each(function() { //循环每个店铺
      var oprice = 0; //店铺总价
      $(this).find(".goodsCheck").each(function() { //循环店铺里面的商品
        if ($(this).is(":checked")) { //如果该商品被选中
            var num = parseInt($(this).parents(".aui-car-box-list-item").find(".num").text()); //得到商品的数量
            var price = parseFloat($(this).parents(".aui-car-box-list-item").find(".price").text()); //得到商品的单价
            var discount_num = parseInt($(this).parents(".aui-car-box-list-item").find(".aui-car-box-list-item-discount-count").text()); //得到打折商品数量
            var discount_price = parseFloat($(this).parents(".aui-car-box-list-item").find(".aui-car-box-list-item-discount-price").text()); //得到打折商品价格
            var origin_price = parseFloat($(this).parents(".aui-car-box-list-item").find(".aui-car-box-list-item-origin-price").text()); //得到打折商品价格
            var total = 0; //计算单个商品的总价
            if (num >= discount_num) {
              $(this).parents(".aui-car-box-list-item").find(".price").text(discount_price);
              total = discount_price * num;
            }else{
              $(this).parents(".aui-car-box-list-item").find(".price").text(origin_price);
              total = origin_price * num;
            };
          oprice += total; //计算该店铺的总价
        }
        $(this).closest(".aui-car-box").find(".ShopTotal").text(oprice.toFixed(2)); //显示被选中商品的店铺总价
      });
      var oneprice = parseFloat($(this).find(".ShopTotal").text()); //得到每个店铺的总价
      allprice += oneprice; //计算所有店铺的总价
    });
    $("#AllTotal").text(allprice.toFixed(2)); //输出全部总价
  }
  TotalPrice();
});
