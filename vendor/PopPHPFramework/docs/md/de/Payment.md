Pop PHP Framework
=================

Documentation : Payment
-----------------------

Home

Der Payment-Komponente bietet standardisierte FunktionalitÃ¤t zur
Kreditkartenzahlung Zugriffe Ã¼ber eine 3rd-Party-Gateway zu
verarbeiten. Die aktuellen eingebauten und unterstÃ¼tzten Gateways sind:

-   Authorize.net
-   PayLeap
-   PayPal
-   TrustCommerce
-   UsaEpay

Jedoch, wenn die UnterstÃ¼tzung fÃ¼r einen anderen Gateway benÃ¶tigt
wird, dann wÃ¤re es einfach, unkompliziert um eine Adapter dafÃ¼r.

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
