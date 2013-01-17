Pop PHP Framework
=================

Documentation : Payment
-----------------------

El componente de pago ofrece una funcionalidad estándar para procesar las solicitudes de pago con tarjeta de crédito a través de una puerta de entrada de 3 ª parte. Las pasarelas actuales integrados y soportados son:

* Authorize.net
* PayLeap
* PayPal
* TrustCommerce
* UsaEpay

Sin embargo, si el soporte para una puerta de entrada diferente se requiere, entonces sería fácil de escribir sólo un adaptador para ello.

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
