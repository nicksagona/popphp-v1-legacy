Pop PHP Framework
=================

Documentation : Auth
--------------------

Auth компонент обеспечивает аутентификацию и авторизацию пользователей на основе базового набора учетных данных и определена роль. Аутентификации аспект обрабатывает аутентификации пользователя для определения того, не то, что пользователь имеет право на все. Разрешение аспект обрабатывает определения того, не прошедших проверку подлинности пользователь достаточно доступ будет разрешен в пределах определенной области. Роли могут быть легко определены и оценены для определения уровня пользователя на доступ. Auth компонент может легко связать в таблицу базы данных или файлов на диске для получения учетных данных и информации.

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
