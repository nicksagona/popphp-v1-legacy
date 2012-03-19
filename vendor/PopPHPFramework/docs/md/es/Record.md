Pop PHP Framework
=================

Documentation : Record
----------------------

El componente de registro, como se indica en el resumen de la documentación, es un "híbrido" de clases entre el registro activo y los patrones de datos de tabla de puerta de enlace. A través de una API estandarizada, puede proporcionar acceso a una sola fila o registro dentro de una tabla de base de datos o varias filas o registros a la vez. El enfoque más común es la de escribir una clase de niño que extiende la clase Registro que representa una tabla en la base de datos. El nombre de la clase niño debe ser el nombre de la mesa. Por la simple creación de


<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

you create a class that has all of the functionality of the Record component built in and the class knows the name of the database table to query from the class name. For example,  'Users' translates into `users` or 'DbUsers' translates into `db_users` (CamelCase is automatically converted into lower_case_underscore.) From there, you can fine-tune the child class that represents the table with various class properties such as:

<pre>
// Table prefix, if applicable
protected $prefix = null;

// Primary ID, if applicable, defaults to 'id'
protected $primaryId = 'id';

// Whether the table is auto-incrementing or not
protected $auto = true;

// Whether to use prepared statements or not, defaults to true
protected $usePrepared = true;
</pre>

Desde allí, el uso básico es como sigue:


<pre>
use Users;

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
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
