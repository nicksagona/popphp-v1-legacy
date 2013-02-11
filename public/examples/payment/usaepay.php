<?php

require_once '../../bootstrap.php';

use Pop\Payment\Payment;
use Pop\Payment\Adapter\UsaEpay;

try {
    $payment = new Payment(new UsaEpay('SOURCE_KEY', Payment::TEST));

    $payment->cardNum = 'XXXXXXXXXXXXXXXX';
    $payment->amount = '25.00';
    $payment->expDate = '12/13';
    $payment->ccv = '123';

    $payment->send();

    if ($payment->isApproved()) {
        echo "You're approved!" . PHP_EOL;
        echo $payment->getMessage();
    } else if ($payment->isDeclined()) {
        echo "You were declined!" . PHP_EOL;
        echo $payment->getMessage();
    } else if ($payment->isError()) {
        echo "There was an error!" . PHP_EOL;
        echo $payment->getMessage();
    }
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
