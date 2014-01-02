Pop PHP Framework
=================

Documentation : Payment
-----------------------

Home

付款组件提供标准化的功能，通过第三方网关来处理信用卡支付请求。目前内置和支持的网关是：

-   Authorize.net
-   PayLeap
-   PayPal
-   TrustCommerce
-   UsaEpay

但是，如果需要支持不同的网关，那么这将是简单的，只写一个适配器它。

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
