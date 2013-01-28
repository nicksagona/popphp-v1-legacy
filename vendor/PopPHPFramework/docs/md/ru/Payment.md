Pop PHP Framework
=================

Documentation : Payment
-----------------------

Home

ÐžÐ¿Ð»Ð°Ñ‚Ð° ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¾Ð±ÐµÑ?Ð¿ÐµÑ‡Ð¸Ð²Ð°ÐµÑ‚
Ñ?Ñ‚Ð°Ð½Ð´Ð°Ñ€Ñ‚Ð¸Ð·Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ñ‹Ðµ Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¸ Ð´Ð»Ñ?
Ð¾Ð±Ñ€Ð°Ð±Ð¾Ñ‚ÐºÐ¸ Ð·Ð°Ð¿Ñ€Ð¾Ñ?Ð¾Ð² ÐºÑ€ÐµÐ´Ð¸Ñ‚Ð½Ñ‹Ñ… ÐºÐ°Ñ€Ñ‚
Ð¾Ð¿Ð»Ð°Ñ‚Ñ‹ Ñ‡ÐµÑ€ÐµÐ· ÑˆÐ»ÑŽÐ· Ñ‚Ñ€ÐµÑ‚ÑŒÐµÐ¹ Ñ?Ñ‚Ð¾Ñ€Ð¾Ð½Ð¾Ð¹. Ð’
Ð½Ð°Ñ?Ñ‚Ð¾Ñ?Ñ‰ÐµÐµ Ð²Ñ€ÐµÐ¼Ñ? Ð²Ñ?Ñ‚Ñ€Ð¾ÐµÐ½Ð½Ñ‹Ðµ Ð¸
Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÐµÐ¼Ñ‹Ñ… ÑˆÐ»ÑŽÐ·Ð¾Ð² Ñ?Ð²Ð»Ñ?ÑŽÑ‚Ñ?Ñ?:

-   Authorize.net
-   PayLeap
-   PayPal
-   TrustCommerce
-   UsaEpay

ÐžÐ´Ð½Ð°ÐºÐ¾, ÐµÑ?Ð»Ð¸ Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶ÐºÐ° Ñ€Ð°Ð·Ð»Ð¸Ñ‡Ð½Ñ‹Ñ…
ÑˆÐ»ÑŽÐ·Ð¾Ð² Ð½Ðµ Ñ‚Ñ€ÐµÐ±ÑƒÐµÑ‚Ñ?Ñ?, Ñ‚Ð¾ Ñ?Ñ‚Ð¾ Ð±Ñ‹Ð»Ð¾ Ð±Ñ‹
Ð¿Ñ€Ð¾Ñ?Ñ‚Ð¾ Ð¿Ñ€Ð¾Ñ?Ñ‚Ð¾ Ð½Ð°Ð¿Ð¸Ñ?Ð°Ñ‚ÑŒ Ð°Ð´Ð°Ð¿Ñ‚ÐµÑ€ Ð´Ð»Ñ?
Ð½ÐµÐ³Ð¾.

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
