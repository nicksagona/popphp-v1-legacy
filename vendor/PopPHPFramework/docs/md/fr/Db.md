Pop PHP Framework
=================

Documentation : Db
------------------

La composante Db offre un accès normalisé aux bases de données de la requête. Les cartes prises en charge sont les suivants:


* mysql
* mysqli
* pdo
* pgsql
* sqlite

Les requêtes préparées sont pris en charge avec le Mysqli, PDO, PgSQL et adapaters Sqlite. Les valeurs d'échappement sont disponibles pour tous les adaptateurs.


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

En plus de l'accès base de données, le composant Db dispose également d'un objet utile abstraction Sql qui vous assiste dans la création de requêtes SQL normalisées.


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
