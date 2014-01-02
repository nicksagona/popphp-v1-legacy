Pop PHP Framework
=================

Documentation : Payment
-----------------------

Home

Der Payment-Komponente bietet standardisierte Funktionalität zur
Kreditkartenzahlung Zugriffe über eine 3rd-Party-Gateway zu verarbeiten.
Die aktuellen eingebauten und unterstützten Gateways sind:

-   Authorize.net
-   PayLeap
-   PayPal
-   TrustCommerce
-   UsaEpay

Jedoch, wenn die Unterstützung für einen anderen Gateway benötigt wird,
dann wäre es einfach, unkompliziert um eine Adapter dafür.

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
