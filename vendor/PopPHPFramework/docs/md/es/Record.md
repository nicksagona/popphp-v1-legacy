Pop PHP Framework
=================

Documentation : Record
----------------------

Home

El componente de grabación, como se indica en el resumen de la
documentación, es un "híbrido" de clases entre el Registro de la tabla
de datos activo y los patrones de Gateway. A través de una API
normalizada, puede facilitar el acceso a una única fila o registro
dentro de una tabla de base de datos o varias filas o registros a la
vez. El método más común es escribir una clase hija que se extiende la
clase de registro que representa una tabla en la base de datos. El
nombre de la clase hija debe ser el nombre de la tabla. Por la simple
creación de

    use Pop\Record\Record;

    class Users extends Record { }

se crea una clase que tiene toda la funcionalidad del componente de
grabación construido en la clase y conoce el nombre de la tabla de base
de datos para consultar el nombre de la clase. Por ejemplo, se traduce
'Usuarios' en \`usuarios\` o 'traduce' en \`DbUsers db\_users\`
(CamelCase se convierte automáticamente en lower\_case\_underscore).
Desde allí, se puede ajustar con precisión la clase de niño que
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

Si usted está dentro de un proyecto estructurado que tiene un adaptador
de base de datos definida, entonces el componente Record recogerá eso y
lo utilizan. Sin embargo, si usted simplemente está escrito algunos
guiones rápidos utilizando el componente de grabación, entonces usted
tendrá que saber qué adaptador de base de datos a utilizar:

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
