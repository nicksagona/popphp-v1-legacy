Pop PHP Framework
=================

Documentation : Db
------------------

Home

El componente Db proporciona acceso normalizado a bases de datos de
consulta. Los adaptadores soportados son:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

Declaraciones preparadas son compatibles con el MySQLi, Oracle, PDO,
PostgreSQL, SQLite y adaptadores sqlsrv. Los valores de escape están
disponibles para todos los adaptadores.

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

Además de conexión a base de datos, el componente Db también cuenta con
un útil objeto Sql abstracción que le ayuda a crear consultas SQL
estándar.

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
