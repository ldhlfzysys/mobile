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
?>