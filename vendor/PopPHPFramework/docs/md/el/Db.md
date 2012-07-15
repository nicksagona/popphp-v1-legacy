Pop PHP Framework
=================

Documentation : Db
------------------

Η συνιστώσα της DB παρέχει πρόσβαση σε κανονικοποιημένη ερωτήματα σε βάσεις δεδομένων. Οι προσαρμογείς υποστηρίζονται είναι οι εξής:

* mssql (via sqlsrv)
* mysql
* mysqli
* oracle
* pdo
* pgsql
* sqlite

Τα παρασκευασμένα δηλώσεις υποστηρίζονται από την MSSQL (via SqlSrv), MySQLi, Oracle, PDO, PostgreSQL, ΠΟΠ, SQLite  και  adapaters. Δραπέτευσε τιμές είναι διαθέσιμες για όλους τους προσαρμογείς.

<pre>
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
$db->adapter->query('SELECT * FROM users');

// Fetch the results
while (($row = $db->adapter->fetch()) != false) {
    print_r($row);
}
</pre>

Εκτός από την πρόσβαση σε βάσεις δεδομένων, το στοιχείο Δβ διαθέτει επίσης ένα χρήσιμο αντικείμενο αφαίρεσης SQL που σας βοηθά στη δημιουργία τυποποιημένων ερωτήματα SQL.

<pre>
use Pop\Db\Sql;

$sql = new Sql('users');
$sql->setIdQuoteType(Sql::BACKTICK)
    ->select()
    ->where('id', '=', 1);

// Outputs 'SELECT * FROM `users` WHERE `id` = 1'
echo $sql;
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
