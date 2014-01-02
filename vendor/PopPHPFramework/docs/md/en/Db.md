Pop PHP Framework
=================

Documentation : Db
------------------

Home

The Db component provides normalized access to query databases. The
supported adapters are:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

Prepared statements are supported with the MySQLi, Oracle, PDO,
PostgreSQL, SQLite and SQLSrv adapters. Escaped values are available for
all of the adapters.

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

In addition to database access, the Db component also features a useful
Sql abstraction object that assists you in creating standardized SQL
queries.

    use Pop\Db\Db;
    use Pop\Db\Sql;

    $db = Db::factory('Sqlite', array('database' => 'mydb.sqlite'));

    $sql = new Sql($db, 'users');
    $sql->select()
        ->where()->equalTo('id', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

The Record class, as outlined in the documentation overview, is a "hybrid" of sorts between the Active Record and Table Gateway patterns. Via a standardized API, it can provide access to a single row or record within a database table, or multiple rows or records at once. The most common approach is to write a child class that extends the Record class that represents a table in the database. The name of the child class should be the name of the table. By simply creating:

    use Pop\Db\Record;

    class Users extends Record { }

you create a class that has all of the functionality of the Record class built in and the class knows the name of the database table to query from the class name. For example,  'Users' translates into `users` or 'DbUsers' translates into `db_users` (CamelCase is automatically converted into lower_case_underscore.) From there, you can fine-tune the child class that represents the table with various class properties such as:

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

If you're within a structured project that has a defined database adapter, then the Record class will pick that up and use it. However, if you are simply writing some quick scripts using the Record component, then you will need to tell it which database adapter to use:

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

From there, basic usage is as follows:

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
