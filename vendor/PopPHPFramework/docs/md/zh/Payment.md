Pop PHP Framework
=================

Documentation : Payment
-----------------------

Home

ä»˜æ¬¾ç»„ä»¶æ??ä¾›æ
‡å‡†åŒ–çš„åŠŸèƒ½ï¼Œé€šè¿‡ç¬¬ä¸‰æ–¹ç½‘å…³æ?¥å¤„ç?†ä¿¡ç”¨å?¡æ”¯ä»˜è¯·æ±‚ã€‚ç›®å‰?å†…ç½®å’Œæ”¯æŒ?çš„ç½‘å…³æ˜¯ï¼š

-   Authorize.net
-   PayLeap
-   PayPal
-   TrustCommerce
-   UsaEpay

ä½†æ˜¯ï¼Œå¦‚æžœéœ€è¦?æ”¯æŒ?ä¸?å?Œçš„ç½‘å…³ï¼Œé‚£ä¹ˆè¿™å°†æ˜¯ç®€å?•çš„ï¼Œå?ªå†™ä¸€ä¸ªé€‚é…?å™¨å®ƒã€‚

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
