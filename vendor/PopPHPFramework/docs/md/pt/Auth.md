Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

O componente Auth facilita a autenticação e autorização de usuários com
base em um conjunto básico de credenciais e papéis definidos. O aspecto
de autenticação lida com a autenticação de um usuário para determinar se
ou não que o usuário é permitido a todos. O aspecto de autorização lida
determinar se o usuário autenticado tem acesso suficiente para ser
permitido dentro de uma determinada área. As funções podem ser
facilmente definida e avaliada para determinar o nível de um usuário de
acesso. O componente Auth pode facilmente amarrar em uma tabela de banco
de dados ou um arquivo em disco para recuperar as credenciais do usuário
e informações.

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
