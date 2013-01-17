Pop PHP Framework
=================

Documentation : Payment
-----------------------

O componente de pagamento fornece funcionalidade padronizado para processar os pedidos de pagamento por cartão de crédito através de um gateway parte 3. Os gateways atuais internas e suportados são:

* Authorize.net
* PayLeap
* PayPal
* TrustCommerce
* UsaEpay

No entanto, se o suporte para um gateway diferente é necessária, então seria simples escrever apenas um adaptador para ele.

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
