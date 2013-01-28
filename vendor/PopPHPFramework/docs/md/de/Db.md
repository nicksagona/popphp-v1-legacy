Pop PHP Framework
=================

Documentation : Db
------------------

Home

Die Db-Komponente bietet normierten Zugang zu Datenbanken abzufragen.
Die unterstützten Adapter sind:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

Prepared Statements werden mit dem MySQLi, Oracle, PDO, PostgreSQL,
SQLite und sqlsrv Adaptern unterstützt. Entgangen Werte sind für alle
Adapter.

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

Neben Zugriff auf die Datenbank, die DB-Komponente bietet auch einen
nützlichen Sql Abstraktion Objekt, das Sie beim Erstellen von
standardisierten SQL-Abfragen.

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
