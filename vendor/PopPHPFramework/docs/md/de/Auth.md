Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

Die Auth Komponente ermöglicht die Authentifizierung und Autorisierung
von Benutzern auf einem grundlegenden Satz von Anmeldeinformationen und
definierten Rollen. Der Authentifizierungs Aspekt handhabt
Authentifizierung eines Benutzers zu bestimmen, ob dieser Benutzer
überhaupt zugelassen ist. Die Autorisierung Aspekt Handgriffe zu
bestimmen, ob der authentifizierte Benutzer hat genug Zugriff auf in
einem gewissen Bereich erlaubt ist. Rollen können einfach definiert und
ausgewertet werden, um eines Benutzers Zugriffsebene bestimmen. Die Auth
Komponente lässt sich einfach in einer Datenbank-Tabelle oder einer
Datei auf der Festplatte, um die Anmeldeinformationen und Informationen
abzurufen binden.

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
