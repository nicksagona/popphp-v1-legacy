Pop PHP Framework
=================

Documentation : Auth
--------------------

El componente Auth facilita la autenticación y autorización de usuarios en función de un conjunto básico de las credenciales y los roles definidos. El aspecto de autenticación se encarga de autenticar a un usuario para determinar si o no que el usuario puede en absoluto. El aspecto de la autorización se encarga de determinar si el usuario autenticado tiene acceso suficiente a permitir dentro de un área determinada. Funciones pueden ser fácilmente definidos y evaluados para determinar el nivel de un usuario de acceso. El componente Auth puede vincular a una tabla de base de datos o un archivo en el disco para recuperar las credenciales de usuario e información.

<pre>
use Pop\Auth\Auth,
    Pop\Auth\Role,
    Pop\Auth\Adapter\AuthFile,
    Pop\Auth\Adapter\AuthTable;

// Create the Auth object using a table in the database or a local access file.
$auth = new Auth(new AuthTable('MyApp\\Table\\Users'), 0, Auth::ENCRYPT_SHA1);
//$auth = new Auth(new AuthFile('../access/users.txt'), 0, Auth::ENCRYPT_SHA1);

// Add some roles
$auth->addRoles(array(
    Role::factory('admin', 3),
    Role::factory('editor', 2),
    Role::factory('reader', 1)
));

// Define some other auth parameters and authenticate the user
$auth->setRequiredRole('admin')
     ->setAttemptLimit(3)
     ->setAllowedIps('127.0.0.1')
     ->authenticate($username, $password);

// Check if the user is authorized to be in this area
if ($auth->isValid()) {
    if ($auth->isAuthorized()) {
        echo 'The user is authorized in this area.';
    } else {
        echo 'The user is NOT authorized in this area.';
    }
} else {
    echo 'Authenication failed. The user is not valid. ' . $auth->getResultMessage();
}
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
