<?php

if(isset($_GET['paymentId']) && isset($_GET['token']) && isset($_GET['PayerID']) )
{
	$paymentId = $_GET['paymentId'];
	$token = $_GET['token'];
	$payerId = $_GET['PayerID'];

    require __DIR__  . '/PayPal-PHP-SDK/autoload.php';
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'Ab82B6sLde42x7Yq5HOoYeAQfyygb_ggOYwHMyPgaI1UbPd7g-ZxgXSOpPJCfoygdQ35gK9qhTPcNdlK',     // ClientID
            'EIBKokMDElw5701dYk3uKRV2ujxHL_z2-KT3sYIcKJ4EhYhZJaEjPrQ_QTZfcBx65BFeIL4r41cQvVyT'      // ClientSecret
        )
    );
    use \PayPal\Api\Payment;
    try {
        $payment = Payment::get($paymentid, $apiContext);
    } catch (Exception $ex) {
           ResultPrinter::printError("Get Payment", "Payment", null, null, $ex);
        exit(1);
    }
    echo $payment;
}

?>