Pop PHP Framework
=================

Documentation : Payment
-----------------------

Home

المكون الدفع يوفر وظائف موحدة لمعالجة طلبات الدفع بواسطة بطاقة ائتمان
عبر بوابة 3rd الطرف. العبارات الحالية المدمج في والمدعومة هي:

-   Authorize.net
-   PayLeap
-   PayPal
-   TrustCommerce
-   UsaEpay

ومع ذلك، إذا كان مطلوبا لدعم بوابة مختلفة، ثم لكان من السهل أن يكتب فقط
محول لذلك.

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
