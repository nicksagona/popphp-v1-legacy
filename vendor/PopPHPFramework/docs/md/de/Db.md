Pop PHP Framework
=================

Documentation : Db
------------------

Der DB-Komponente bietet Zugang zu den normalisierten Datenbanken abzufragen. Die unterstützten Adapter sind:

* sqlsrv
* mysql
* mysqli
* oracle
* pdo
* pgsql
* sqlite

Prepared Statements werden mit der SQLSrv, MySQLi, Oracle, PDO, PostgreSQL und SQLite adapaters unterstützt. Entkommen Werte sind für alle Adapter.

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
$db->adapter()->query('SELECT * FROM users');

// Fetch the results
while (($row = $db->adapter()->fetch()) != false) {
    print_r($row);
}
</pre>

Neben Zugriff auf die Datenbank, die DB-Komponente bietet auch eine nützliche Abstraktion Sql-Objekt, das Sie beim Erstellen von standardisierten SQL-Abfragen.

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
