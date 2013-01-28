Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

Le composant Auth facilite l'authentification et l'autorisation des
utilisateurs basés sur un ensemble d'informations d'identification de
base et les rôles définis. L'aspect d'authentification gère
l'authentification d'un utilisateur de déterminer si oui ou non
l'utilisateur est autorisé à tous. L'aspect autorisation poignées de
déterminer si oui ou non l'utilisateur authentifié a accès suffisant à
être admis dans une certaine zone. Rôles peuvent facilement être
déterminées et évaluées pour déterminer le niveau de l'utilisateur de
l'accès. Le composant Auth peut lier facilement dans une table de base
de données ou d'un fichier sur le disque pour récupérer les informations
d'identification et d'information.

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
