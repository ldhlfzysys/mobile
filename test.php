<?php
    include_once('./cart.php');
    function getCartIdByUser($userId){
        $client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
        $session = $client->login('mobile', 'mobile');
        $params = array('customerid'=>$userId);
        $args = array('store' => '16');
        try {

            //过的购物车id
            $result = $client->call($session, 'cart.quotebyuserid', $params);
            return $result;
            // $result = $client->call($session, 'cart.info','268', $args);
        }
        catch (Exception $e) { //while an error has occured
            echo "==> Error: ".$e->getMessage();
        }
        // var_dump($result);
    }


    function productListTest(){
        $client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
        $session = $client->login('mobile', 'mobile');
        $complexFilter = array(
                'status' => 1
        );
        $args = array(
            'filters' => $complexFilter,
            'storeView' => '16'
        );
        $result = $client->call($session, 'catalog_product.list',$args);
        $client->endSession($session);
        return $result;
    }


    function pInfo($id){
        $client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
        $session = $client->login('mobile', 'mobile');
       $args = array(
            'productId' => $id,
            'storeView' => 'china'
        );
        $res = $client->call($session, 'catalog_product.info', $args);
        $client->endSession($session);
        return $res;
    }

    if (isset($_GET['userId'])) {
        $userId = $_GET['userId'];
        $cartId = getCartIdByUser($userId);

        if ($cartId == 0) {
            echo "cartid = 0";
        }else{
            $result = cart($cartId);
            if ($result['payment']['payment_id'] == null) {
                # code...
                // echo 'payment_id == null';
            }
            // echo json_encode($payment);
            echo json_encode($result);
            // foreach ($result['items'] as $key => $value) {
            //     echo json_encode($value) . '<br>';
            // }
        }
    }

    if (isset($_GET['pList'])) {
        $res = productListTest();
        echo json_encode($res);
    }

    if (isset($_GET['pid'])) {
        $id = $_GET['pid'];
        $res = pInfo($id);
        echo json_encode($res);
    }




?>