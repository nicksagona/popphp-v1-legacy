Pop PHP Framework
=================

Documentation : Db
------------------

Home

Η συνιστώσα Db παρέχει πρόσβαση σε κανονικοποιημένη ερωτήματα σε βάσεις
δεδομένων. Οι προσαρμογείς υποστηρίζονται είναι οι εξής:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

Οι δηλώσεις που υποστηρίζονται παρασκευασμένα με τη MySQLi, Oracle, ΠΟΠ,
PostgreSQL, SQLite και SQLSrv προσαρμογείς. Escaped τιμές είναι
διαθέσιμα για όλους τους προσαρμογείς.

    use Pop\Db\Db;

    // Define DB credentials
    $creds = array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34'
    );

    // Create DB object
    $db = Db::factory('Mysqli', $creds);

    // Perform the query
    $db->adapter()->query('SELECT * FROM users');

    // Fetch the results
    while (($row = $db->adapter()->fetch()) != false) {
        print_r($row);
    }

Εκτός από την πρόσβαση σε βάσεις δεδομένων, η συνιστώσα Db διαθέτει
επίσης ένα χρήσιμο αντικείμενο αφαίρεση Sql που σας βοηθά στη δημιουργία
τυποποιημένων ερωτημάτων SQL.

    use Pop\Db\Db;
    use Pop\Db\Sql;

    $db = Db::factory('Sqlite', array('database' => 'mydb.sqlite'));

    $sql = new Sql($db, 'users');
    $sql->select()
        ->where()->equalTo('id', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

Η τάξη εγγραφής, όπως περιγράφεται στην επισκόπηση τεκμηρίωση, είναι ένα "υβρίδιο" του είδους μεταξύ του Active Record και τα σχέδια πύλη πίνακα. Μέσω ενός τυποποιημένο API, μπορεί να παρέχει πρόσβαση σε μία μόνο γραμμή ή εγγραφή σε έναν πίνακα βάσης δεδομένων, ή πολλαπλές σειρές ή αρχεία ταυτόχρονα. Η πιο κοινή προσέγγιση είναι να γράψετε μια κατηγορία παιδιών που επεκτείνει την τάξη εγγραφής που αντιπροσωπεύει έναν πίνακα στη βάση δεδομένων. Το όνομα της κατηγορίας παιδιού θα πρέπει να είναι το όνομα του πίνακα. Με απλά δημιουργώντας:

    use Pop\Db\Record;

    class Users extends Record { }

μπορείτε να δημιουργήσετε μια κατηγορία που έχει όλες τις λειτουργίες της τάξης Εγγραφή ενσωματωμένο και η τάξη δεν ξέρει το όνομα του πίνακα της βάσης δεδομένων για την υποβολή ερωτημάτων από το όνομα της κλάσης. Για παράδειγμα, μεταφράζεται «Χρήστες» σε χρήστες `` ή μεταφράζεται »DbUsers» σε db_users `` (CamelCase μετατρέπεται αυτόματα σε lower_case_underscore.) Από εκεί, μπορείτε να ρυθμίσετε την κατηγορία παιδί που αντιπροσωπεύει τον πίνακα με διάφορες ιδιότητες, όπως η τάξη :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Αν είστε μέσα σε ένα δομημένο πρόγραμμα που έχει οριστεί προσαρμογέα βάσης δεδομένων, τότε η τάξη εγγραφής θα πάρει ότι και να το χρησιμοποιήσετε. Ωστόσο, εάν γράφετε απλά κάποιες γρήγορες scripts χρησιμοποιώντας το εξάρτημα εγγραφής, τότε θα πρέπει να το πουν οι οποίες προσαρμογέα βάσης δεδομένων για χρήση:

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

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
