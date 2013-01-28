Pop PHP Framework
=================

Documentation : Payment
-----------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† Ø§Ù„Ø¯Ù?Ø¹ ÙŠÙˆÙ?Ø± ÙˆØ¸Ø§Ø¦Ù? Ù…ÙˆØ­Ø¯Ø© Ù„Ù…Ø¹Ø§Ù„Ø¬Ø©
Ø·Ù„Ø¨Ø§Øª Ø§Ù„Ø¯Ù?Ø¹ Ø¨ÙˆØ§Ø³Ø·Ø© Ø¨Ø·Ø§Ù‚Ø© Ø§Ø¦ØªÙ…Ø§Ù† Ø¹Ø¨Ø±
Ø¨ÙˆØ§Ø¨Ø© 3rd Ø§Ù„Ø·Ø±Ù?. Ø§Ù„Ø¹Ø¨Ø§Ø±Ø§Øª Ø§Ù„Ø­Ø§Ù„ÙŠØ© Ø§Ù„Ù…Ø¯Ù…Ø¬
Ù?ÙŠ ÙˆØ§Ù„Ù…Ø¯Ø¹ÙˆÙ…Ø© Ù‡ÙŠ:

-   Authorize.net
-   PayLeap
-   PayPal
-   TrustCommerce
-   UsaEpay

ÙˆÙ…Ø¹ Ø°Ù„ÙƒØŒ Ø¥Ø°Ø§ ÙƒØ§Ù† Ù…Ø·Ù„ÙˆØ¨Ø§ Ù„Ø¯Ø¹Ù… Ø¨ÙˆØ§Ø¨Ø©
Ù…Ø®ØªÙ„Ù?Ø©ØŒ Ø«Ù… Ù„ÙƒØ§Ù† Ù…Ù† Ø§Ù„Ø³Ù‡Ù„ Ø£Ù† ÙŠÙƒØªØ¨ Ù?Ù‚Ø·
Ù…Ø­ÙˆÙ„ Ù„Ø°Ù„Ùƒ.

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
