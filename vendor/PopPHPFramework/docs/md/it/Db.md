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

    use Pop\Db\Db;
    use Pop\Db\Sql;

    $db = Db::factory('Sqlite', array('database' => 'mydb.sqlite'));

    $sql = new Sql($db, 'users');
    $sql->select()
        ->where()->equalTo('id', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

La classe Record, come indicato nella documentazione panoramica, è un "ibrido" di sorta tra l'Active Record e modelli Gateway Tabella. Grazie ad una API standard, è in grado di fornire l'accesso a una singola riga o record all'interno di una tabella di database, o più righe o record contemporaneamente. L'approccio più comune è quello di scrivere una classe figlia che estende la classe record che rappresenta una tabella nel database. Il nome della classe figlio dovrebbe essere il nome della tabella. Con la semplice creazione di:

    use Pop\Db\Record;

    class Users extends Record { }

si crea una classe che dispone di tutte le funzionalità della classe Record costruito e la classe conosce il nome della tabella di database per eseguire query dal nome della classe. Ad esempio, si traduce 'utenti INTO `utenti` o si traduce "DbUsers' in` `(db_users CamelCase viene automaticamente convertito in lower_case_underscore.) Da lì, è possibile ottimizzare la classe figlia che rappresenta la tabella con le proprietà di classe diverse, quali :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Se sei all'interno di un progetto strutturato che ha una scheda di database definito, allora la classe Record prenderà che fino e utilizzarlo. Tuttavia, se si sta semplicemente scrivendo alcuni script veloci utilizzando il componente di registrazione, allora si avrà bisogno di dire quale scheda database da utilizzare:

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

Da lì, uso di base è la seguente:

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
