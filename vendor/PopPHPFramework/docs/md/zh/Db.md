Pop PHP Framework
=================

Documentation : Db
------------------

DB组件提供查询数据库的规范化访问。所支持的适配器：

* sqlsrv
* mysql
* mysqli
* oracle
* pdo
* pgsql
* sqlite

支持和SQLSrv， MySQLi，Oracle， PDO，PostgreSQL的SQLite的adapaters准备好的语句。逃脱的值是所有适配器。

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

除了访问数据库，DB组件还设有一个有用的SQL抽象对象，帮助您建立标准化的SQL查询。

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
