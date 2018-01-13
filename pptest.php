<?php

if (isset($_GET['cartid'])) {
    require __DIR__  . '/PayPal-PHP-SDK/autoload.php';
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'Ab82B6sLde42x7Yq5HOoYeAQfyygb_ggOYwHMyPgaI1UbPd7g-ZxgXSOpPJCfoygdQ35gK9qhTPcNdlK',     // ClientID
            'EIBKokMDElw5701dYk3uKRV2ujxHL_z2-KT3sYIcKJ4EhYhZJaEjPrQ_QTZfcBx65BFeIL4r41cQvVyT'      // ClientSecret
        )
    );

    #取购物车内容
    $cartid = $_GET['cartid'];
    $client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
    $session = $client->login('mobile', 'mobile');
    $args = array(
        'store' => '16'
    );
    $cartInfo = $client->call($session, 'cart.info',$cartid, $args);

    var_dump($cartInfo);
    return;
    #user
    $payer = new \PayPal\Api\Payer();
    $payer->setPaymentMethod('paypal');

    $payerinfo = new \PayPal\Api\PayerInfo();
    $payerinfo->setEmail();
    $payerinfo->setFirstName();
    $payerinfo->setLastName();
    $payerinfo->setPhone();
    $payerinfo->setCountryCode();

    #账单地址
    $billing_json_str = $_POST['billing_address'];
    $billing_info = json_decode($billing_json_str,true);
    $billing_address = new \PayPal\Api\Address();
    $billing_address->
    $billing_address->
    $billing_address->
    $billing_address->
    $billing_address->
    $billing_address->
    $billing_address->

    $payerinfo->setBillingAddress($billing_address);

    #收货地址
    $payerinfo->setShippingAddress();

    $payer->setPayerInfo($payerinfo);


    $amount = new \PayPal\Api\Amount();
    $amount->setTotal('2.4');
    $amount->setCurrency('CAD');


    #添加商品
    $itemList = new \PayPal\Api\ItemList();
    $items_json_str = $_POST['items'];
    $items = json_decode($items_json_str,true);
    foreach ($items as $product) {
        $item = new \PayPal\Api\Item();
        $item->setSku($product["sku"]);
        $item->setName($product["name"]);
        $item->setCurrency("CAD");
        $item->setPrice($product["price"]);
        $item->setTax($product["tax"]);
        $item->setQuantity($product["qty"]);
        $item->setDescription($product["description"]);
        $item->setUrl($product["url"]);
        $itemList->addItem($item);
    }


    #paypal传输的类
    $transaction = new \PayPal\Api\Transaction();
    $transaction->setAmount($amount);
    $transaction->setItemList($itemList);

    #回调地址
    $redirectUrls = new \PayPal\Api\RedirectUrls();
    $redirectUrls->setReturnUrl("http://bdbbuy.com/mobile/ppcallback.php")
        ->setCancelUrl("http://bdbbuy.com/mobile/ppcallback.php");

    #支付对象
    $payment = new \PayPal\Api\Payment();
    $payment->setIntent('sale')
        ->setPayer($payer)
        ->setTransactions(array($transaction))
        ->setRedirectUrls($redirectUrls);

    // 4. Make a Create Call and print the values
    try {
        $payment->create($apiContext);
        echo $payment;

        echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
    }
    catch (\PayPal\Exception\PayPalConnectionException $ex) {
        // This will print the detailed information on the exception.
        //REALLY HELPFUL FOR DEBUGGING
        echo $ex->getData();
    }
}
