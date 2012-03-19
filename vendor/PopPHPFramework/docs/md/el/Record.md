Pop PHP Framework
=================

Documentation : Record
----------------------

Η συνιστώσα της εγγραφής, όπως περιγράφεται στην επισκόπηση τεκμηρίωση, είναι ένα «υβρίδιο» του είδους μεταξύ της ενεργούς και πρότυπα πύλης πίνακα δεδομένων. Μέσω τυποποιημένη API, μπορεί να παρέχει πρόσβαση σε μία μόνο γραμμή ή εγγραφή σε έναν πίνακα βάσης δεδομένων, ή πολλαπλές σειρές ή αρχεία ταυτόχρονα. Η πιο συνηθισμένη προσέγγιση είναι να γράψει μια κλάση-παιδί που επεκτείνει την τάξη εγγραφής που αντιπροσωπεύει έναν πίνακα στη βάση δεδομένων. Το όνομα του παιδιού στην τάξη πρέπει να είναι το όνομα του πίνακα. Με απλά δημιουργώντας


<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

you create a class that has all of the functionality of the Record component built in and the class knows the name of the database table to query from the class name. For example,  'Users' translates into `users` or 'DbUsers' translates into `db_users` (CamelCase is automatically converted into lower_case_underscore.) From there, you can fine-tune the child class that represents the table with various class properties such as:

<pre>
// Table prefix, if applicable
protected $prefix = null;

// Primary ID, if applicable, defaults to 'id'
protected $primaryId = 'id';

// Whether the table is auto-incrementing or not
protected $auto = true;

// Whether to use prepared statements or not, defaults to true
protected $usePrepared = true;
</pre>

Από εκεί, βασική χρήση είναι ως εξής:


<pre>
use Users;

// Get a single user
$user = Users::findById(1001);
echo $user->name;
echo $user->email;

// Get multiple users
$users = Users::findAll('last_name ASC');
foreach ($users->rows as $user) {
    echo $user->name;
    echo $user->email;
}
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
