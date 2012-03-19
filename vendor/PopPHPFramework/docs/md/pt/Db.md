Pop PHP Framework
=================

Documentation : Db
------------------

O componente Db fornece acesso às bases de dados de consulta normalizado. Os adaptadores suportados são:


* mysql
* mysqli
* pdo
* pgsql
* sqlite

As declarações preparadas são suportados com o mysqli, DOP, Pgsql e adapaters sqlite. Valores escaparam estão disponíveis para todos os adaptadores.


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

Além do acesso ao banco de dados, o componente Db também apresenta um objeto Sql abstração útil que ajuda você a criar consultas SQL padronizados.


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
