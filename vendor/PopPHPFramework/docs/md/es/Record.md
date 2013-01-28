Pop PHP Framework
=================

Documentation : Record
----------------------

Home

El componente de grabaciÃ³n, como se indica en el resumen de la
documentaciÃ³n, es un "hÃ­brido" de clases entre el Registro de la tabla
de datos activo y los patrones de Gateway. A travÃ©s de una API
normalizada, puede facilitar el acceso a una Ãºnica fila o registro
dentro de una tabla de base de datos o varias filas o registros a la
vez. El mÃ©todo mÃ¡s comÃºn es escribir una clase hija que se extiende
la clase de registro que representa una tabla en la base de datos. El
nombre de la clase hija debe ser el nombre de la tabla. Por la simple
creaciÃ³n de

    use Pop\Record\Record;

    class Users extends Record { }

se crea una clase que tiene toda la funcionalidad del componente de
grabaciÃ³n construido en la clase y conoce el nombre de la tabla de base
de datos para consultar el nombre de la clase. Por ejemplo, se traduce
'Usuarios' en \`usuarios\` o 'traduce' en \`DbUsers db\_users\`
(CamelCase se convierte automÃ¡ticamente en lower\_case\_underscore).
Desde allÃ­, se puede ajustar con precisiÃ³n la clase de niÃ±o que
representa la tabla con las propiedades de clases diferentes, tales
como:

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

Si usted estÃ¡ dentro de un proyecto estructurado que tiene un adaptador
de base de datos definida, entonces el componente Record recogerÃ¡ eso y
lo utilizan. Sin embargo, si usted simplemente estÃ¡ escrito algunos
guiones rÃ¡pidos utilizando el componente de grabaciÃ³n, entonces usted
tendrÃ¡ que saber quÃ© adaptador de base de datos a utilizar:

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

A partir de ahÃ­, el uso bÃ¡sico es el siguiente:

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
