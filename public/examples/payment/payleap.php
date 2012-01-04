<?php

require_once '../../bootstrap.php';

use Pop\Payment\Payment,
    Pop\Payment\Adapter\PayLeap;

try {
    $payment = new Payment(new PayLeap('API_ID', 'TRANS_KEY', Payment::TEST));

    $payment->cardNum = '4111222233334444';
    $payment->amount = '25.27';
    $payment->expDate = '10/13';

    $payment->send();

    //if ($payment->isApproved()) {
    //    echo "You're approved!" . PHP_EOL;
    //    echo $payment->getMessage();
    //} else if ($payment->isDeclined()) {
    //    echo "You were declined!" . PHP_EOL;
    //    echo $payment->getMessage();
    //} else if ($payment->isError()) {
    //    echo "There was an error!" . PHP_EOL;
    //    echo $payment->getMessage();
    //}

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>