<?php

    $client = new SoapClient('https://bdbbuy.com/index.php/api/soap/?wsdl');  
    $session = $client->login('mobile', 'mobile');

    $params = array('customerid'=>'4');

    $args = array('store' => '16');

    try {

        //过的购物车id
        $result = $client->call($session, 'cart.quotebyuserid', $params);
        // $result = $client->call($session, 'cart.info','268', $args);
    }
    catch (Exception $e) { //while an error has occured
        echo "==> Error: ".$e->getMessage();
    }
    var_dump($result);

?>