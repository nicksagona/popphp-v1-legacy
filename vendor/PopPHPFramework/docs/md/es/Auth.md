Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

El componente Auth facilita la autenticaciÃ³n y autorizaciÃ³n de
usuarios en funciÃ³n de un conjunto bÃ¡sico de credenciales y roles
definidos. El aspecto de autenticaciÃ³n se encarga de autenticar a un
usuario para determinar si o no que el usuario estÃ¡ permitido en
absoluto. El aspecto autorizaciÃ³n maneja determinar si el usuario
autenticado tiene acceso suficiente a permitir dentro de un Ã¡rea
determinada. Roles pueden ser fÃ¡cilmente definidos y evaluados para
determinar el nivel de acceso del usuario. El componente Auth puede atar
a una tabla de base de datos o un archivo en el disco para recuperar las
credenciales de usuario y la informaciÃ³n.

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
