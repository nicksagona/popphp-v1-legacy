Pop PHP Framework
=================

Documentation : Version
-----------------------

The VersiΗ συνιστώσα Έκδοση παρέχει απλώς τη δυνατότητα να προσδιορίσετε ποια έκδοση της ποπ θα έχουν ρεύμα, και ποια είναι η τελευταία διαθέσιμα είναι. Επίσης, το στοιχείο αυτό χρησιμοποιείται από την συνιστώσα CLI για την εκτέλεση της εξάρτησης-ελέγχου.

<pre>
use Pop\Version;

echo Version::getVersion();

if (Version::compareVersion(1.0) == 1) {
    echo 'The current version is less than 1.0';
} else {
    echo 'The current version is greater than or equal to 1.0';
}
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
