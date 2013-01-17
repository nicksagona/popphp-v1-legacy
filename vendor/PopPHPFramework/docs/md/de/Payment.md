Pop PHP Framework
=================

Documentation : Payment
-----------------------

Der Payment-Komponente bietet standardisierte Funktionalität zur Kreditkartenzahlung Zugriffe über eine 3rd-Party-Gateway verarbeitet werden. Die aktuellen eingebauten und unterstützten Gateways sind:

* Authorize.net
* PayLeap
* PayPal
* TrustCommerce
* UsaEpay

Allerdings, wenn die Unterstützung für ein anderes Gateway benötigt wird, dann wäre es einfach, schreiben Sie einfach einen Adapter dafür.

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

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
