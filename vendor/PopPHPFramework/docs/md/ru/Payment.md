Pop PHP Framework
=================

Documentation : Payment
-----------------------

Оплата компонент предоставляет стандартизированные функции для обработки запросов кредитных карт оплаты через 3-й шлюз стороны. В настоящее время встроенные и поддерживает шлюзы:

* Authorize.net
* PayLeap
* PayPal
* TrustCommerce
* UsaEpay

Однако, если поддержка различных шлюзов требуется, то это было бы просто, чтобы просто написать адаптер для него.

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
