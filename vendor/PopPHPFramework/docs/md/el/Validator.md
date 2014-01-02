Pop PHP Framework
=================

Documentation : Validator
-------------------------

Home

Η συνιστώσα Validator παρέχει απλά λειτουργικότητα επικύρωσης για πολλές
διαφορετικές περιπτώσεις χρήσης, όπως επικύρωση ή όχι ένας αριθμός είναι
από μια ορισμένη αξία ή ένα string είναι αλφαριθμητικό. Οι πιο
προχωρημένοι επικυρωτές είναι διαθέσιμα, καθώς, όπως επικύρωση μια
διεύθυνση ηλεκτρονικού ταχυδρομείου, καθώς και τη διεύθυνση IP ή έναν
αριθμό πιστωτικής κάρτας. Και, αν αυτό που χρειάζεται δεν είναι
διαθέσιμη, του εξαρτήματος μπορεί εύκολα να επεκταθεί.

    use Pop\Validator\AlphaNumeric;

    // Create an alphanumeric validator
    $val = new AlphaNumeric();

    // Evaluate if the input value meets the rule or not
    if (!$val->evaluate('abcd1234')) {
        echo $val->getMessage();
    } else {
        echo 'The validator test passed. The string is alphanumeric.';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
