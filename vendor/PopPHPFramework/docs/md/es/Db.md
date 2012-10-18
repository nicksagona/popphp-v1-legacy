Pop PHP Framework
=================

Documentation : Db
------------------

El componente DB proporciona un acceso normalizado a bases de datos de consulta. Los adaptadores soportados son:

* sqlsrv
* mysql
* mysqli
* oracle
* pdo
* pgsql
* sqlite

Declaraciones preparadas son compatibles con el SQLSrv, MySQLi, Oracle, PDO, PostgreSQL y SQLite adapaters. Los valores de escape están disponibles para todos los adaptadores.

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

Además del acceso a la base de datos, el componente de Db también cuenta con un útil objeto SQL abstracción que le asiste en la creación de consultas SQL estándar.

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
