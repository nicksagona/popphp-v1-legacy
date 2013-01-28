Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

Auth компонент обеспечивает аутентификацию и авторизацию пользователей
на основе базового набора учетных данных и определенные роли.
Аутентификации аспект ручки аутентификации пользователя для определения
того, не то, что пользователь имеет право на все. Разрешение аспект
ручки определения того, не авторизованный пользователь имеет достаточный
доступ будет разрешен в пределах определенной области. Роли могут быть
легко определены и оценены, чтобы определить уровень пользователем
доступа. Auth компонент может легко связать в таблице базы данных или
файл на диске для получения учетных данных и информации.

    use Pop\Auth;

    // Set the username and password
    $username = 'testuser3';
    $password = '90test12';

    // Create auth object
    $auth = new Auth\Auth(new Auth\Adapter\File('../assets/files/access.txt'), Auth\Auth::ENCRYPT_SHA1);

    // Add some roles
    $auth->addRoles(array(
        Auth\Role::factory('admin', 3),
        Auth\Role::factory('editor', 2),
        Auth\Role::factory('reader', 1)
    ));

    // Define some other auth parameters and authenticate the user
    $auth->setRequiredRole('admin')
         ->setAttemptLimit(3)
         ->setAllowedIps('127.0.0.1')
         ->authenticate($username, $password);

    echo $auth->getResultMessage() . '<br /> ' . PHP_EOL;

    // Check if the user is authorized to be in this area
    if ($auth->isValid()) {
        if ($auth->isAuthorized()) {
            echo 'The user "' . $auth->getUser()->getUsername() .
                 '" is authorized as a "' .  $auth->getUser()->getRole()->getName() . '".';
        } else {
            echo 'The user "' . $auth->getUser()->getUsername() .
                 '" is NOT authorized. The user is a "' .  $auth->getUser()->getRole()->getName() .
                 '" and needs to be a "' . $auth->getRequiredRole()->getName() . '".';
        }
    }

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
