Pop PHP Framework
=================

Documentation : Db
------------------

DBコンポーネントは、クエリのデータベースへの正規化されたアクセスを提供します。サポートされているアダプタは以下のとおりです。


* mysql
* mysqli
* pdo
* pgsql
* sqlite

プリペアドステートメントは、のMysqli、PDO、pgsqlで、SQLiteのadapatersでサポートされています。逃げられた値は、アダプタのすべての利用可能です。


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

データベースへのアクセスに加えて、DBコンポーネントはまた、標準化されたSQLクエリを作成するのに役立ち便利なSQLの抽象化オブジェクトを提供しています。


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
