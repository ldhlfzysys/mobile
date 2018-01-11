<?php



if (isset($_POST['items']) && isset($_POST['billing_address']) && isset($_POST['shipping_address']) && isset($_POST['amount'])) {
    require __DIR__  . '/PayPal-PHP-SDK/autoload.php';
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'Ab82B6sLde42x7Yq5HOoYeAQfyygb_ggOYwHMyPgaI1UbPd7g-ZxgXSOpPJCfoygdQ35gK9qhTPcNdlK',     // ClientID
            'EIBKokMDElw5701dYk3uKRV2ujxHL_z2-KT3sYIcKJ4EhYhZJaEjPrQ_QTZfcBx65BFeIL4r41cQvVyT'      // ClientSecret
        )
    );

    #user
    $payer = new \PayPal\Api\Payer();
    $payer->setPaymentMethod('paypal');

    $payerinfo = new \PayPal\Api\PayerInfo();
    $payerinfo->setEmail();
    $payerinfo->setFirstName();
    $payerinfo->setLastName();
    $payerinfo->setPhone();
    $payerinfo->setCountryCode();
    $payerinfo->setBillingAddress();
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
        $item->setSku("123");
        $item->setName("苹果");
        $item->setCurrency("CAD");
        $item->setPrice("1.2");
        $item->setTax("0.01");
        $item->setQuantity("2");
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
