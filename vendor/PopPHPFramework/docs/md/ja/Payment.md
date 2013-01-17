Pop PHP Framework
=================

Documentation : Payment
-----------------------

支払コンポーネントは、サードパーティ製のゲートウェイを介してクレジットカードでの支払い要求を処理するために標準化された機能を提供します。現在内蔵され、サポートされているゲートウェイは、次のとおりです。

* Authorize.net
* PayLeap
* PayPal
* TrustCommerce
* UsaEpay

別のゲートウェイのサポートが必要な場合しかし、それはちょうどそれのためのアダプタを記述する単純なものだろう。

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
