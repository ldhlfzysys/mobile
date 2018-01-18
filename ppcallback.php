<?php
require __DIR__  . '/PayPal-PHP-SDK/autoload.php';
use PayPal\Api\Payment;

if(isset($_GET['paymentId']) && isset($_GET['token']) && isset($_GET['PayerID']) )
{
	$paymentId = $_GET['paymentId'];
	$token = $_GET['token'];
	$payerId = $_GET['PayerID'];

    
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'Ab82B6sLde42x7Yq5HOoYeAQfyygb_ggOYwHMyPgaI1UbPd7g-ZxgXSOpPJCfoygdQ35gK9qhTPcNdlK',     // ClientID
            'EIBKokMDElw5701dYk3uKRV2ujxHL_z2-KT3sYIcKJ4EhYhZJaEjPrQ_QTZfcBx65BFeIL4r41cQvVyT'      // ClientSecret
        )
    );


    try {
        $payment = Payment::get($paymentId, $apiContext);
    } catch (Exception $ex) {
           ResultPrinter::printError("Get Payment", "Payment", null, null, $ex);
        exit(1);
    }

    if ($payment) {
        $paymentObject = json_decode($payment,true);

        $cartid = $paymentObject['transactions'][0]['invoice_number'];
        if ($cartid != null) {
            $client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');    
            $session = $client->login('mobile', 'mobile');
            $result = $client->call($session,'cart.order',array($cartid));

            if (strpos($result,"160") === 0) {
                setcookie("bdb-ci", '');
                echo '<script>url="http://bdbbuy.com/mobile/payResult.html";window.location.href=url;</script> ';
            }
        }


    }
}

?>