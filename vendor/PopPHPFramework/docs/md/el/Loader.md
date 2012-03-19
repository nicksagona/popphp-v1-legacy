Pop PHP Framework
=================

Documentation : Loader
----------------------

Η συνιστώσα Loader είναι ίσως η πιο βασική, ακόμα πιο σημαντικό συστατικό της Ποπ-πλαίσιο PHP. Είναι το στοιχείο που οδηγεί αυτόματη φόρτωση δυνατότητες του πλαισίου, και τη δική σας εφαρμογή μπορεί εύκολα να καταχωρηθεί με την Autoloader για να φορτώσετε τις δικές σας κατηγορίες. Αυτό αντικαθιστά singlehandedly όλα αυτά τα παλιά καταστάσεις περιλαμβάνουν χρησιμοποιήσατε για να έχετε όλη τη χώρα. Τώρα, το μόνο που χρειάζεστε είναι ένα απαιτούν δήλωση του «bootstrap.php» στην κορυφή και είστε καλοί να πάτε. Από προεπιλογή, το αρχείο εκκίνησης περιέχει την απαιτούμενη αναφορά στην κατηγορία Autoloader του πλαισίου και στη συνέχεια, φορτώνει επάνω. Στο αρχείο εκκίνησης, μπορείτε να εκτελέσετε εύκολα σε άλλες λειτουργίες φόρτωσης, όπως η καταχώρηση ονομάτων της εφαρμογής σας με το Autoloader, ή τη φόρτωση ενός αρχείου classmap για να μειώσετε το χρόνο φόρτωσης.

<pre>
// Instantiate the autoloader object
$autoloader = new Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

$autoloader->register('YourLib', '../vendor/YourLib/src');
$autoloader->loadClassMap('../vendor/YourLib/classmap.php');
</pre>

Και αν χρειάζεστε μια classmap δημιουργείται αρχείο, το στοιχείο Loader έχει τη λειτουργικότητα να δημιουργήσει εύκολα ένα classmap αρχείο για εσάς.


<pre>
// Generate a classmap file
Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
