Pop PHP Framework
=================

Documentation : Validator
-------------------------

Η συνιστώσα Validator παρέχει απλά λειτουργικότητα επικύρωσης για πολλά διαφορετικά σενάρια χρήσης, όπως την επικύρωση ή όχι ο αριθμός είναι από μια συγκεκριμένη τιμή ή ένα string είναι αλφαριθμητικό. Πιο προχωρημένη επικυρωτές είναι διαθέσιμα, καθώς, όπως επικύρωση μια διεύθυνση ηλεκτρονικού ταχυδρομείου και τη διεύθυνση IP ή έναν αριθμό πιστωτικής κάρτας. Και, αν αυτό που χρειάζεται δεν είναι διαθέσιμο, του στοιχείου μπορεί να επεκταθεί εύκολα.

<pre>
use Pop\Validator\Validator,
    Pop\Validator\Validator\AlphaNumeric;

// Create an alphanumeric validator
$val = Validator::factory(new AlphaNumeric());

// Evaluate if the input value meets the rule or not
if (!$val->evaluate('abcd1234')) {
    echo $val->getMessage();
} else {
    echo 'The validator test passed. The string is alphanumeric.';
}
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
