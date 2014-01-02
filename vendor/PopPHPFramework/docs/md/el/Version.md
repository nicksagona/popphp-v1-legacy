Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

Η συνιστώσα Έκδοση παρέχει απλώς τη δυνατότητα να προσδιορίσετε ποια
έκδοση της Ποπ θα έχουν ρεύμα, και ποια είναι η τελευταία διαθέσιμα
είναι. Επίσης, αυτό το συστατικό χρησιμοποιείται από το συστατικό CLI να
εκτελέσει την εξάρτηση-ελέγχου.

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
