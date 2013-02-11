<?php

require_once '../../bootstrap.php';

use Pop\Payment\Payment;
use Pop\Payment\Adapter\PayLeap;

try {
    $payment = new Payment(new PayLeap('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));

    $payment->cardNum = '4111111111111111';
    $payment->amount = '25.27';
    $payment->expDate = '12/13';

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
