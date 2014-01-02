Pop PHP Framework
=================

Documentation : Db
------------------

Home

La composante Db offre un accès normalisé aux bases de données de la
requête. Les adaptateurs pris en charge sont les suivants:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

Les requêtes préparées sont pris en charge avec le MySQLi, Oracle, AOP,
PostgreSQL, SQLite et adaptateurs sqlsrv. Valeurs échappés sont
disponibles pour tous les adaptateurs.

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

En plus de l'accès base de données, la composante Db dispose également
d'un objet Sql abstraction utile qui vous assiste dans la création de
requêtes SQL standard.

    use Pop\Db\Db;
    use Pop\Db\Sql;

    $db = Db::factory('Sqlite', array('database' => 'mydb.sqlite'));

    $sql = new Sql($db, 'users');
    $sql->select()
        ->where()->equalTo('id', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

La classe enregistrement, comme indiqué dans la liste des documents, est un «hybride» de toutes sortes entre l'Active Record et les modèles de passerelle de table. Via une interface standardisée, il peut donner accès à une seule ligne ou enregistrement dans une table de base de données, ou plusieurs lignes ou des dossiers à la fois. L'approche la plus courante consiste à écrire une classe enfant qui étend la classe enregistrement qui représente une table dans la base de données. Le nom de la classe de l'enfant doit être le nom de la table. En créant simplement:

    use Pop\Db\Record;

    class Users extends Record { }

vous créez une classe qui dispose de toutes les fonctionnalités de la classe enregistrement intégré et la classe connaît le nom de la table de base de données à interroger à partir du nom de la classe. Par exemple, se traduit par «Utilisateurs» dans `utilisateurs` ou traduit 'DbUsers' sur `` db_users (CamelCase est automatiquement converti en lower_case_underscore.) A partir de là, vous pouvez affiner la classe enfant qui représente la table de propriétés de la classe divers tels que :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Si vous êtes dans un projet structuré qui possède une carte de base de données défini, alors la classe enregistrement sera ramasser ça et l'utiliser. Toutefois, si vous êtes tout simplement à écrire des scripts rapides en utilisant le composant enregistrement, alors vous aurez besoin de le dire adaptateur de base de données qui à utiliser:

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

A partir de là, l'utilisation de base est la suivante:

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
