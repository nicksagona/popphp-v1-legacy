Pop PHP Framework
=================

Documentation : Db
------------------

Home

Db компонент обеспечивает доступ к нормированной запросов к базам
данных. Поддерживаемых адаптеров являются:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

Подготовленные заявления поддерживаются с MySQLi, Oracle, PDO,
PostgreSQL, SQLite и SQLSRV адаптеров. Сбежавший значения доступны для
всех адаптеров.

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

В дополнение к доступ к базе данных, Db компонент также имеет полезные
абстракции SQL объекта, который помогает вам в создании
стандартизированного SQL запросов.

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
