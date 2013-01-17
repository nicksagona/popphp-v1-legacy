Pop PHP Framework
=================

Documentation : Db
------------------

Db компонент обеспечивает доступ к нормированной запросы к базам данных. Поддерживаемые адаптеры:

* sqlsrv
* mysql
* mysqli
* oracle
* pdo
* pgsql
* sqlite

Подготовленные заявления поддерживаются SQLSrv, MySQLi, Oracle, PDO, PostgreSQL и SQLite adapaters. Сбежавший значения доступны для всех адаптеров.

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

Кроме доступа к базе данных, Db компонент также имеет полезную абстракцию Sql объект, который помогает в создании стандартизированных SQL запросов.

<pre>
use Pop\Db\Sql;

$sql = new Sql('users');
$sql->setIdQuoteType(Sql::BACKTICK)
    ->select()
    ->where('id', '=', 1);

// Outputs 'SELECT * FROM `users` WHERE `id` = 1'
echo $sql;
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
