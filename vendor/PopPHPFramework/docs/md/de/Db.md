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

    use Pop\Db\Db;
    use Pop\Db\Sql;

    $db = Db::factory('Sqlite', array('database' => 'mydb.sqlite'));

    $sql = new Sql($db, 'users');
    $sql->select()
        ->where()->equalTo('id', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

Die Record-Klasse, wie in der Dokumentation Überblick skizziert, ist ein "Hybrid" der Arten zwischen dem Active Record und Tabelle Gateway-Muster. Über eine standardisierte API, können sie den Zugang zu einer einzelnen Zeile oder Datensatz in einer Datenbank-Tabelle oder mehrere Zeilen oder Datensätze auf einmal liefern. Die häufigste Methode ist, ein Kind zu Klasse, die die Record-Klasse, die eine Tabelle in der Datenbank stellt sich schreiben. Der Name des Kindes Klasse sollte der Name der Tabelle. Indem einfach:

    use Pop\Db\Record;

    class Users extends Record { }

Sie erstellen eine Klasse, die die gesamte Funktionalität der Record-Klasse in und die Klasse kennt den Namen der Datenbank-Tabelle aus den Namen der Klasse abzufragen gebaut hat. Zum Beispiel, 'Users' übersetzt in `users` oder 'DbUsers' übersetzt in `db_users` (CamelCase wird automatisch in lower_case_underscore umgewandelt.) Von dort aus können Sie die Feinabstimmung der Kind-Klasse, die die Tabelle mit verschiedenen Klassen Eigenschaften wie stellt :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Wenn Sie innerhalb eines strukturierten Projekt, das eine definierte Datenbank-Adapter hat, dann sind die Record-Klasse holen, dass bis und zu nutzen. Allerdings, wenn Sie einfach schriftlich sind einige schnelle Skripte mit den Record-Komponente, dann werden Sie brauchen, um es welche Datenbank-Adapter sagen, zu verwenden:

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

Von dort sind grundlegende Verwendung wie folgt:

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
