<?php
ini_set('display_errors',1); 
if (isset($_POST['cartid'])) {
    require __DIR__  . '/PayPal-PHP-SDK/autoload.php';
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'Ab82B6sLde42x7Yq5HOoYeAQfyygb_ggOYwHMyPgaI1UbPd7g-ZxgXSOpPJCfoygdQ35gK9qhTPcNdlK',     // ClientID
            'EIBKokMDElw5701dYk3uKRV2ujxHL_z2-KT3sYIcKJ4EhYhZJaEjPrQ_QTZfcBx65BFeIL4r41cQvVyT'      // ClientSecret
        )
    );

    #取购物车内容
    $cartid = $_POST['cartid'];
    $client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');  
    $session = $client->login('mobile', 'mobile');
    $args = array(
        'store' => '16'
    );
    $cartInfo = $client->call($session, 'cart.info',$cartid, $args);
    $billing_info = $cartInfo['billing_address'];
    $shipping_info = $cartInfo['shipping_address'];

    #必要数据
    $mail = $cartInfo['customer_email'];
    $firstname = $cartInfo['customer_firstname'];
    $lastname = $cartInfo['customer_lastname'];

    #user
    $payer = new \PayPal\Api\Payer();
    $payer->setPaymentMethod('paypal');

    $payerinfo = new \PayPal\Api\PayerInfo();
    $payerinfo->setEmail($mail);
    $payerinfo->setFirstName($firstname);
    $payerinfo->setLastName($lastname);
    $payerinfo->setCountryCode('CA');
    $payerinfo->setPhone($billing_info['telephone']);

    #账单地址
    $billing_address = new \PayPal\Api\Address();
    $billing_address->setLine1($billing_info['street']);//street
    $billing_address->setCity($billing_info['city']);
    $billing_address->setCountryCode('CA');
    $billing_address->setPostalCode($billing_info['postcode']);
    $payerinfo->setBillingAddress($billing_address);

    #收货地址
    $shipping_address = new \PayPal\Api\ShippingAddress();
    $shipping_address->setLine1($shipping_info['street']);//street
    $shipping_address->setCity($shipping_info['city']);
    $shipping_address->setCountryCode('CA');
    $shipping_address->setPostalCode($shipping_info['postcode']);
    $payerinfo->setShippingAddress($shipping_address);

    #设置用户
    // $payer->setPayerInfo($payerinfo);

    #添加商品
    $itemList = new \PayPal\Api\ItemList();

    $items = $cartInfo['items'];
    foreach ($items as $product) {
        $item = new \PayPal\Api\Item();
        $item->setSku($product["sku"]);
        $item->setName($product["name"]);
        $item->setCurrency("CAD");
        $item->setPrice($product["price"]);
        $item->setTax($product["tax_amount"]);
        $item->setQuantity($product["qty"]);
        $itemList->addItem($item);
    }
    $itemList->setShippingAddress($shipping_address);
    $itemList->setShippingPhoneNumber($shipping_info['telephone']);


    $detail = new \PayPal\Api\Details();
    $detail->setSubtotal($cartInfo['subtotal']);
    $detail->setTax($shipping_info['tax_amount']);
    $detail->setShipping($shipping_info['shipping_amount']);


    $amount = new \PayPal\Api\Amount();
    $amount->setDetails($detail);
    $amount->setTotal($cartInfo['grand_total']);
    $amount->setCurrency('CAD');


    #paypal传输的类
    $transaction = new \PayPal\Api\Transaction();
    $transaction->setAmount($amount);
    $transaction->setItemList($itemList);
    $transaction->setInvoiceNumber($cartid);
    $transaction->setReferenceId($cartid);

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

    // var_dump($payment);

    // 4. Make a Create Call and print the values
    try {
        $payment->create($apiContext);
        // echo $payment;
        echo $payment->getApprovalLink();
    }
    catch (\PayPal\Exception\PayPalConnectionException $ex) {
        // This will print the detailed information on the exception.
        //REALLY HELPFUL FOR DEBUGGING
        echo $ex->getData();
    }
}
