Pop PHP Framework
=================

Documentation : Db
------------------

Home

Il componente Db fornisce l'accesso normalizzato per interrogare i
database. Le schede supportate sono:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

Dichiarazioni preparate sono supportati con il MySQLi, Oracle, DOP,
PostgreSQL, SQLite e adattatori sqlsrv. I valori di escape sono
disponibili per tutte le schede.

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

Oltre a accesso al database, il componente Db dispone anche di un utile
oggetto astrazione Sql che vi assiste nella creazione di query SQL
standard.

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
