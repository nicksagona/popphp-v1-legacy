Pop PHP Framework
=================

Documentation : Auth
--------------------

Le composant Auth facilite l'authentification et l'autorisation des utilisateurs basés sur un ensemble de base des lettres de créance et les rôles définis. L'aspect d'authentification gère l'authentification d'un utilisateur de déterminer si oui ou non que l'utilisateur est autorisé à tous. L'aspect autorisation poignées de déterminer si oui ou non l'utilisateur authentifié a un accès suffisant à être admis dans une certaine zone. Les rôles peuvent être facilement définis et évalués afin de déterminer le niveau d'un utilisateur de l'accès. Le composant Auth pouvez facilement lier dans une table de base de données ou un fichier sur le disque pour récupérer les informations d'identification utilisateur et des informations.

<pre>
use Pop\Auth\Auth,
    Pop\Auth\Role,
    Pop\Auth\Adapter\AuthFile,
    Pop\Auth\Adapter\AuthTable;

// Create the Auth object using a table in the database or a local access file.
$auth = new Auth(new AuthTable('MyApp\\Table\\Users'), Auth::ENCRYPT_SHA1);
//$auth = new Auth(new AuthFile('../access/users.txt'), Auth::ENCRYPT_SHA1);

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
