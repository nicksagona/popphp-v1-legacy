Pop PHP Framework
=================

Documentation : Auth
--------------------

O componente Auth facilita autenticação e autorização de usuários com base em um conjunto básico de credenciais e papéis definidos. O aspecto de autenticação lida com autenticação de um usuário para determinar se ou não que o usuário é permitido a todos. O aspecto de autorização lida determinar se o usuário autenticado tem acesso suficiente a ser permitido dentro de uma determinada área. As funções podem ser facilmente definida e avaliada para determinar o nível de um usuário de acesso. O componente Auth pode facilmente amarrar em uma tabela de banco de dados ou um arquivo em disco para recuperar as credenciais do usuário e informação.


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
