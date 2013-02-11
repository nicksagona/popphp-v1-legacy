<?php

require_once '../../bootstrap.php';

use Pop\Payment\Payment;
use Pop\Payment\Adapter\PayPal;

try {
    $payment = new Payment(new PayPal(
        'USERNAME',
        'PASSWORD',
        'SIGNATURE',
        Payment::TEST
    ));

    $payment->cardNum = '4111111111111111';
    $payment->ccv = '123';
    $payment->amount = '50.00';
    $payment->expDate = '122016';
    $payment->firstName = 'Bob';
    $payment->lastName = 'Smith';
    $payment->address = '123 Main St.';
    $payment->city = 'New Orleans';
    $payment->state = 'LA';
    $payment->zip = '70130';

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
