Pop PHP Framework
=================

Documentation : Payment
-----------------------

Home

Î— ÏƒÏ…Î½Î¹ÏƒÏ„ÏŽÏƒÎ± Ï€Î»Î·Ï?Ï‰Î¼ÏŽÎ½ Ï€Î±Ï?Î­Ï‡ÎµÎ¹
Ï„Ï…Ï€Î¿Ï€Î¿Î¹Î·Î¼Î­Î½Î· Î»ÎµÎ¹Ï„Î¿Ï…Ï?Î³Î¹ÎºÏŒÏ„Î·Ï„Î± Î³Î¹Î± Ï„Î·Î½
ÎµÏ€ÎµÎ¾ÎµÏ?Î³Î±ÏƒÎ¯Î± Ï„Ï‰Î½ Î±Î¹Ï„Î®ÏƒÎµÏ‰Î½ Ï€Î»Î·Ï?Ï‰Î¼Î®Ï‚ Î¼Îµ
Ï€Î¹ÏƒÏ„Ï‰Ï„Î¹ÎºÎ® ÎºÎ¬Ï?Ï„Î± Î¼Î­ÏƒÏ‰ Ï„Î¿Ï… 3Î¿Ï… Ï€Ï?Î»Î· ÎºÏŒÎ¼Î¼Î±.
ÎŸÎ¹ Ï„Ï?Î­Ï‡Î¿Ï…ÏƒÎµÏ‚ ÎµÎ½ÏƒÏ‰Î¼Î±Ï„Ï‰Î¼Î­Î½Î¿ ÎºÎ±Î¹
Ï…Ï€Î¿ÏƒÏ„Î·Ï?Î¯Î¶ÎµÏ„Î±Î¹ Ï€Ï?Î»ÎµÏ‚ ÎµÎ¯Î½Î±Î¹ Î¿Î¹ ÎµÎ¾Î®Ï‚:

-   Authorize.net
-   PayLeap
-   PayPal
-   TrustCommerce
-   UsaEpay

Î©ÏƒÏ„ÏŒÏƒÎ¿, ÎµÎ¬Î½ Î· Ï…Ï€Î¿ÏƒÏ„Î®Ï?Î¹Î¾Î· Î³Î¹Î± Î¼Î¹Î±
Î´Î¹Î±Ï†Î¿Ï?ÎµÏ„Î¹ÎºÎ® Ï€Ï?Î»Î· Î±Ï€Î±Î¹Ï„ÎµÎ¯Ï„Î±Î¹, Ï„ÏŒÏ„Îµ Î¸Î±
Î®Ï„Î±Î½ Î±Ï€Î»ÏŒ Î½Î± Î³Ï?Î¬ÏˆÎµÎ¹ Î¼ÏŒÎ½Î¿ Î­Î½Î±Î½
Ï€Ï?Î¿ÏƒÎ±Ï?Î¼Î¿Î³Î­Î± Î³Î¹Î± Î±Ï…Ï„ÏŒ.

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
