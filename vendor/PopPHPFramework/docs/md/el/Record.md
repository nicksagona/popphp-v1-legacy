Pop PHP Framework
=================

Documentation : Record
----------------------

Home

Η συνιστώσα της εγγραφής, όπως περιγράφεται στην επισκόπηση τεκμηρίωση,
είναι ένα "υβρίδιο" του είδους μεταξύ του Active Record και τα σχέδια
πύλη πίνακα δεδομένων. Μέσω ενός τυποποιημένο API, μπορεί να παρέχει
πρόσβαση σε μία μόνο γραμμή ή εγγραφή σε έναν πίνακα βάσης δεδομένων, ή
πολλαπλές σειρές ή αρχεία ταυτόχρονα. Η πιο κοινή προσέγγιση είναι να
γράψετε μια κατηγορία παιδιών που επεκτείνει την τάξη εγγραφής που
αντιπροσωπεύει έναν πίνακα στη βάση δεδομένων. Το όνομα της κατηγορίας
παιδιού θα πρέπει να είναι το όνομα του πίνακα. Με απλά δημιουργώντας

    use Pop\Record\Record;

    class Users extends Record { }

μπορείτε να δημιουργήσετε μια κατηγορία που έχει όλες τις λειτουργίες
του στοιχείου εγγραφής που χτίστηκε το και η τάξη δεν ξέρει το όνομα του
πίνακα της βάσης δεδομένων για την υποβολή ερωτημάτων από το όνομα της
κλάσης. Για παράδειγμα, μεταφράζεται «Χρήστες» σε χρήστες \`\` ή
μεταφράζεται »DbUsers» σε db\_users \`\` (CamelCase μετατρέπεται
αυτόματα σε lower\_case\_underscore.) Από εκεί, μπορείτε να ρυθμίσετε
την κατηγορία παιδί που αντιπροσωπεύει τον πίνακα με διάφορες ιδιότητες,
όπως η τάξη :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Αν είστε μέσα σε ένα δομημένο πρόγραμμα που έχει οριστεί προσαρμογέα
βάσης δεδομένων, τότε το στοιχείο Εγγραφή ότι θα πάρει μέχρι και να το
χρησιμοποιήσετε. Ωστόσο, εάν γράφετε απλά κάποιες γρήγορες scripts
χρησιμοποιώντας το εξάρτημα εγγραφής, τότε θα πρέπει να το πουν οι
οποίες προσαρμογέα βάσης δεδομένων για χρήση:

    // Define DB credentials
    $creds = array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34'
    );

    // Create DB object
    $db = \Pop\Db\Db::factory('Mysqli', $creds);

    Record::setDb($db);

Από εκεί, βασική χρήση είναι ως εξής:

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
