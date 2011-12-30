<?php

require_once '../../bootstrap.php';

use Pop\Payment\Payment,
    Pop\Payment\Adapter\Authorize;

try {

    $payment = new Payment(new Authorize('XXXXXXXXXX', 'XXXXXXXXXX'));

    $payment->cardNum = 'XXXXXXXXXXXXXXXX';
    $payment->amount = '20.00';
    $payment->expDate = '10/12';

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
?>