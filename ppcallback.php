<?php
ini_set('display_errors',1); 
require __DIR__  . '/PayPal-PHP-SDK/autoload.php';
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

if(isset($_GET['paymentId']) && isset($_GET['token']) && isset($_GET['PayerID']) )
{
	$paymentId = $_GET['paymentId'];
	$token = $_GET['token'];
	$payerId = $_GET['PayerID'];

    // $apiContext = new \PayPal\Rest\ApiContext(
    //     new \PayPal\Auth\OAuthTokenCredential(
    //         'Ab82B6sLde42x7Yq5HOoYeAQfyygb_ggOYwHMyPgaI1UbPd7g-ZxgXSOpPJCfoygdQ35gK9qhTPcNdlK',     // ClientID
    //         'EIBKokMDElw5701dYk3uKRV2ujxHL_z2-KT3sYIcKJ4EhYhZJaEjPrQ_QTZfcBx65BFeIL4r41cQvVyT'      // ClientSecret
    //     )
    // );   
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AX5s9PVAnhgl6X24ygTorm4jRgsZeE19LkzUiNSCK8jPGGdkAVAG8EhT-Fetr8Thxk90FThHWCT2ejI5',     // ClientID
            'EM4od7UoQY02yTTobXDmnZEHuJnvCbwFwPBHkT53MT_nJgJ80AvXrZY5t2JH-dSfeyG6NK7jyUB7SByD'      // ClientSecret
        )
    );
    $apiContext->setConfig(
        array(
            'mode' => 'live',
        )
    );

    try {
        $payment = Payment::get($paymentId, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        $result = $payment->execute($execution, $apiContext);
        try {
            $complete_payment = Payment::get($paymentId, $apiContext);
            if ($complete_payment) {
                $paymentObject = json_decode($complete_payment,true);

                $time_cartid = $paymentObject['transactions'][0]['invoice_number'];
                $cartid = spliti('-', $time_cartid)[1];
                if ($cartid != null) {
                    $client = new SoapClient('http://bdbbuy.com/index.php/api/soap/?wsdl');    
                    $session = $client->login('mobile', 'mobile');
                    $result = $client->call($session,'cart.order',array($cartid));

                    if (strpos($result,"160") === 0) {
                        setcookie("bdb-ci", '');
                        echo '<script>url="https://m.bdbbuy.com/payResult.phtml?oid='.$result.'";window.location.href=url;</script> ';
                    }
                }
            }   
        } catch (Exception $ex) {
            // var_dump($ex);
            $payErrorUrl = "https://m.bdbbuy.com/payError.phtml?msg=";
            // $url = $payErrorUrl . $ex->getData() . ' code = ' . $ex->getCode();
            echo '<script>url="'.$payErrorUrl.'";window.location.href=url;</script> ';
        }
    } catch (Exception $ex) {
        // var_dump($ex);
        $payErrorUrl = "https://m.bdbbuy.com/payError.phtml?msg=";
        // $url = $payErrorUrl . $ex->getData() . ' code = ' . $ex->getCode();
        echo '<script>url="'.$payErrorUrl   .'";window.location.href=url;</script> ';
    }
}

?>