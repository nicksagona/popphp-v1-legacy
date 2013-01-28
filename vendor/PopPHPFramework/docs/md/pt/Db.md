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

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
