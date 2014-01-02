Pop PHP Framework
=================

Documentation : Payment
-----------------------

Home

The Payment component provides standardized functionality to process
credit card payment requests via a 3rd party gateway. The current
built-in and supported gateways are:

-   Authorize.net
-   PayLeap
-   PayPal
-   TrustCommerce
-   UsaEpay

However, if support for a different gateway is required, then it would
be simple to just write an adapter for it.

    use Pop\Payment\Payment,
        Pop\Payment\Adapter\Authorize;

    $payment = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));

    $payment->cardNum = 'XXXXXXXXXXXXXXXX';
    $payment->amount = '27.00';
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

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
