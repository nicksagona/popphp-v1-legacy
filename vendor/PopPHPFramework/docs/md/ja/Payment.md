Pop PHP Framework
=================

Documentation : Payment
-----------------------

Home

æ”¯æ‰•ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?ã‚µãƒ¼ãƒ‰ãƒ‘ãƒ¼ãƒ†ã‚£ã?®ã‚²ãƒ¼ãƒˆã‚¦ã‚§ã‚¤ã‚’ä»‹ã?—ã?¦ã‚¯ãƒ¬ã‚¸ãƒƒãƒˆã‚«ãƒ¼ãƒ‰ã?®æ”¯æ‰•ã?„è¦?æ±‚ã‚’å‡¦ç?†ã?™ã‚‹ã?Ÿã‚?ã?«æ¨™æº–åŒ–ã?•ã‚Œã?Ÿæ©Ÿèƒ½ã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚ç?¾åœ¨ã?®çµ„ã?¿è¾¼ã?¿ã?Šã‚ˆã?³ã‚µãƒ?ãƒ¼ãƒˆã?•ã‚Œã‚‹ã‚²ãƒ¼ãƒˆã‚¦ã‚§ã‚¤ã?¯ã€?æ¬¡ã?®ã?¨ã?Šã‚Šã?§ã?™ã€‚

-   Authorize.net
-   PayLeap
-   PayPal
-   TrustCommerce
-   UsaEpay

ç•°ã?ªã‚‹ã‚²ãƒ¼ãƒˆã‚¦ã‚§ã‚¤ã?®ã‚µãƒ?ãƒ¼ãƒˆã?Œå¿…è¦?ã?ªå
´å?ˆã?¯ã€?ã??ã‚Œã?¯ã??ã‚Œç”¨ã?®ã‚¢ãƒ€ãƒ—ã‚¿ã‚’æ›¸ã??ã?“ã?¨ã?Œç°¡å?˜ã?§ã?—ã‚‡ã?†ã€‚

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
