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

    use Pop\Db\Db;
    use Pop\Db\Sql;

    $db = Db::factory('Sqlite', array('database' => 'mydb.sqlite'));

    $sql = new Sql($db, 'users');
    $sql->select()
        ->where()->equalTo('id', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

La clase Record, como se indica en el resumen de la documentación, es un "híbrido" de clases entre el Active Record y los patrones de la tabla Gateway. A través de una API normalizada, puede facilitar el acceso a una única fila o registro dentro de una tabla de base de datos o varias filas o registros a la vez. El método más común es escribir una clase hija que se extiende la clase de registro que representa una tabla en la base de datos. El nombre de la clase hija debe ser el nombre de la tabla. Por la simple creación:

    use Pop\Db\Record;

    class Users extends Record { }

se crea una clase que tiene toda la funcionalidad de la clase Record construido en la clase y conoce el nombre de la tabla de base de datos para consultar el nombre de la clase. Por ejemplo, se traduce 'Usuarios' en `usuarios` o 'traduce' en `DbUsers db_users` (CamelCase se convierte automáticamente en lower_case_underscore). Desde allí, se puede ajustar con precisión la clase de niño que representa la tabla con las propiedades de clases diferentes, tales como :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Si usted está dentro de un proyecto estructurado que tiene un adaptador de base de datos definida, entonces la clase Record recogerá eso y lo utilizan. Sin embargo, si usted simplemente está escrito algunos guiones rápidos utilizando el componente de grabación, entonces usted tendrá que saber qué adaptador de base de datos a utilizar:

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

A partir de ahí, el uso básico es el siguiente:

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
