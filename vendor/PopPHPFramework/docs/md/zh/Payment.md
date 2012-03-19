Pop PHP Framework
=================

Documentation : Payment
-----------------------

The Payment component provides standardized functionality to process credit card payment requests via a 3rd party gateway.  The current built-in and supported gateways are:

* Authorize.net
* PayLeap
* PayPal
* TrustCommerce
* UsaEpay

然而，如果需要支持不同的网关，然后它会简单地只写它的适配器。


<pre>
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
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
