Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

Το συστατικό Loader είναι ίσως το πιο βασικό, ακόμα πιο σημαντικό
συστατικό της Pop πλαίσιο PHP. Είναι το στοιχείο που οδηγεί autoloading
δυνατότητες του πλαισίου, και τη δική σας εφαρμογή μπορεί εύκολα να
καταχωρηθεί με την autoloader να φορτώσετε τις δικές σας κατηγορίες.
Αυτό αντικαθιστά singlehandedly όλες αυτές τις παλιές δηλώσεις
περιλαμβάνουν χρησιμοποιήσατε για να έχετε σε όλη τη χώρα. Τώρα, το μόνο
που χρειάζεται είναι ένας απαιτούν δήλωση του «bootstrap.php» στην
κορυφή και είστε καλοί να πάτε. Από προεπιλογή, το αρχείο εκκίνησης
περιέχει την απαιτούμενη αναφορά στην κατηγορία Autoloader του πλαισίου
και στη συνέχεια, φορτώνει επάνω. Στο αρχείο εκκίνησης, μπορείτε να
εκτελέσετε εύκολα άλλες λειτουργίες φόρτωσης, όπως την εγγραφή ονομάτων
της εφαρμογής σας με την autoloader, ή τη φόρτωση ενός αρχείου classmap
να μειώσει το χρόνο φόρτωσης.

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

Και αν χρειάζεστε ένα αρχείο που δημιουργείται classmap, το στοιχείο
Loader έχει τη λειτουργικότητα για να δημιουργήσετε εύκολα ένα αρχείο
classmap για σας επίσης.

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
