Pop PHP Framework
=================

Documentation : Payment
-----------------------

Home

支払コンポーネントは、サードパーティのゲートウェイを介してクレジットカードの支払い要求を処理するために標準化された機能を提供します。現在の組み込みおよびサポートされるゲートウェイは、次のとおりです。

-   Authorize.net
-   PayLeap
-   PayPal
-   TrustCommerce
-   UsaEpay

異なるゲートウェイのサポートが必要な場合は、それはそれ用のアダプタを書くことが簡単でしょう。

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
