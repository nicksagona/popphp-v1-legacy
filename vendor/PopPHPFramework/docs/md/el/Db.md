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

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
