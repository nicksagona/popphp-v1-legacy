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
    $username = 'testuser1';
    $password = '12test34';

    // Create auth object
    $auth = new Auth\Auth(
        new Auth\Adapter\File('../assets/files/access-sha1.txt'),
        Auth\Auth::ENCRYPT_SHA1
    );

    // Define some other auth parameters and authenticate the user
    $auth->setAttemptLimit(3)
         ->setAttempts(2)
         ->setAllowedIps('127.0.0.1')
         ->authenticate($username, $password);

    echo $auth->getResultMessage() . '<br /> ' . PHP_EOL;

    // Check if the auth attempt is valid
    if ($auth->isValid()) {
        // The user is valid so do top-secret stuff
    }


    $admin = Auth\Role::factory('admin', 4);
    $editor = Auth\Role::factory('editor', 3);
    $reader = Auth\Role::factory('reader', 2);
    $restricted = Auth\Role::factory('restricted', 1);

    $userRole = $editor;

    $acl = Auth\Acl::factory(array($admin, $editor, $reader));
    $acl->setRequiredRole('reader');

    echo '<h3>Reader Area</h3>' . PHP_EOL;
    echo 'The user is ' . ((!$acl->isAuthorized($userRole)) ? 'NOT ' : null) . 'authorized in the reader area.' . PHP_EOL;

    $acl->setRequiredRole('editor');

    echo '<h3>Editor Area</h3>' . PHP_EOL;
    echo 'The user is ' . ((!$acl->isAuthorized($userRole)) ? 'NOT ' : null) . 'authorized in the editor area.' . PHP_EOL;

    $acl->setRequiredRole('admin');

    echo '<h3>Admin Area</h3>' . PHP_EOL;
    echo 'The user is ' . ((!$acl->isAuthorized($userRole)) ? 'NOT ' : null) . 'authorized in the admin area.' . PHP_EOL;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
