Pop PHP Framework
=================

Documentation : Payment
-----------------------

Η συνιστώσα πληρωμών παρέχει τυποποιημένη λειτουργικότητα για την επεξεργασία των αιτήσεων πληρωμής με πιστωτική κάρτα μέσω ενός τρίτου κόμματος πύλη. Οι τρέχουσες ενσωματωμένη και υποστηριζόμενη πύλες είναι:

* Authorize.net
* PayLeap
* PayPal
* TrustCommerce
* UsaEpay

Ωστόσο, εάν η υποστήριξη για μια διαφορετική πύλη απαιτείται, τότε θα ήταν εύκολο να γράψει μόνο ένα προσαρμογέα για αυτό.

<pre>
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
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
