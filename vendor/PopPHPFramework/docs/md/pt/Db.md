Pop PHP Framework
=================

Documentation : Db
------------------

Home

O componente Db fornece acesso a bases de dados normalizado consulta. Os
adaptadores suportados são:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

Declarações preparadas são suportados com o MySQLi, Oracle, DOP,
PostgreSQL, SQLite e adaptadores sqlsrv. Valores escaparam estão
disponíveis para todos os adaptadores.

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

Além de acesso à base de dados, o componente Db também apresenta um
objeto abstração útil Sql que ajuda você a criar padronizados consultas
SQL.

    use Pop\Db\Db;
    use Pop\Db\Sql;

    $db = Db::factory('Sqlite', array('database' => 'mydb.sqlite'));

    $sql = new Sql($db, 'users');
    $sql->select()
        ->where()->equalTo('id', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

A classe Record, conforme descrito na visão geral da documentação, é um "híbrido" das sortes entre o Active Record e padrões de gateway da tabela. Através de uma API padronizada, pode fornecer acesso a uma única linha ou registro dentro de uma tabela de banco de dados, ou várias linhas ou registros de uma vez. A abordagem mais comum é escrever uma classe filha que estende a classe Record que representa uma tabela no banco de dados. O nome da classe criança deve ser o nome da tabela. Simplesmente criando:

    use Pop\Db\Record;

    class Users extends Record { }

você criar uma classe que tem todas as funcionalidades da classe construído em Registro e da classe sabe o nome da tabela de banco de dados para consulta a partir do nome da classe. Por exemplo, se traduz 'Usuários' em `usuários` ou 'traduz DbUsers' em `db_users` (CamelCase é automaticamente convertido em lower_case_underscore.) De lá, você pode ajustar a classe filha que representa a tabela com as propriedades da classe diversos, tais como :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Se você está dentro de um projeto estruturado, que tem um adaptador de banco de dados definido, então a classe Record vai pegá-lo e usá-lo. No entanto, se você está simplesmente escrever alguns scripts rápidos usando o componente Record, então você precisa dizer a ele qual adaptador de banco de dados para usar:

    // Define DB credentials
    $creds = array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34'
    );

    // Create DB object
    $db = \Pop\Db\Db::factory('Mysqli', $creds);

    Record::setDb($db);

A partir daí, a utilização de base é a seguinte:

    // Get a single user
    $user = Users::findById(1001);
    echo $user->name;
    echo $user->email;

    // Get multiple users
    $users = Users::findAll('last_name ASC');
    foreach ($users->rows as $user) {
        echo $user->name;
        echo $user->email;
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
