<?php
ini_set('display_errors',1); 
require __DIR__  . '/PayPal-PHP-SDK/autoload.php';
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

if(isset($_GET['paymentId']) && isset($_GET['token']) && isset($_GET['PayerID']) )
{
	$paymentId = $_GET['paymentId'];
	$payerId = $_GET['PayerID'];

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

    $payment = Payment::get($paymentId, $apiContext);
    $execution = new PaymentExecution();
    $execution->setPayerId($payerId);

    $transaction = $payment->getTransactions();

    $execution->addTransaction($transaction);

    // var_dump($execution);
    try {
         $result = $payment->execute($execution, $apiContext);
    } catch (Exception $ex) {
    	var_dump($ex);
           // ResultPrinter::printError("Get Payment", "Payment", null, null, $ex);
        exit(1);
    }
    var_dump($result);

}

?>