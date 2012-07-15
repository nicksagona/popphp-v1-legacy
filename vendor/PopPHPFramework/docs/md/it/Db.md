Pop PHP Framework
=================

Documentation : Db
------------------

Il componente Db fornisce l'accesso normalizzato per interrogare i database. Le schede supportate sono:

* mssql (via sqlsrv)
* mysql
* mysqli
* oracle
* pdo
* pgsql
* sqlite

Dichiarazioni preparate sono supportati con il MSSQL (via SqlSrv), MySQLi, Oracle, PDO, PostgreSQL e SQLite adapaters. I valori di escape sono disponibili per tutte le schede.

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

Oltre a l'accesso al database, il componente Db dispone anche di un utile oggetto di astrazione Sql che si assiste nella creazione di query SQL standard.

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
