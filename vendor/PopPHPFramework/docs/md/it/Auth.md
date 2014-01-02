Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

La componente Auth facilita l'autenticazione e l'autorizzazione degli
utenti sulla base di un set di base di credenziali e ruoli definiti.
L'aspetto di autenticazione gestisce l'autenticazione di un utente per
determinare se l'utente è autorizzato a tutti. L'aspetto autorizzazione
gestisce determinare se l'utente autenticato ha accesso sufficienti per
essere ammessi all'interno di una certa area. I ruoli possono essere
facilmente definiti e valutati per determinare il livello di un utente
di accesso. Il componente Auth può facilmente legare in una tabella di
database o un file su disco per recuperare le credenziali dell'utente e
le informazioni.

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

#
    use Pop\Auth\Acl;
    use Pop\Auth\Role;
    use Pop\Auth\Resource;

    // Create some resources
    $page = new Resource('page');
    $template = new Resource('template');

    // Create some roles with permissions
    $reader = Role::factory('reader')->addPermission('read');
    $editor = Role::factory('editor')->addPermission('edit');
    $publisher = Role::factory('publisher')->addPermission('publish');
    $admin = Role::factory('admin')->addPermission('admin');

    // Add roles as child roles to demonstrate inheritance
    $reader->addChild(
        $editor->addChild(
            $publisher->addChild($admin)
        )
    );

    $acl = new Acl();

    $acl->addRoles(array($reader, $editor, $publisher, $admin));
    $acl->addResources(array($page, $template));

    $acl->allow('reader', 'page', 'read')
        ->allow('editor', 'page', array('read', 'edit'))
        ->allow('publisher', 'page')
        ->allow('publisher', 'template', 'read')
        ->allow('admin');

    $acl->deny('editor', 'page', 'read');

    $user = $editor;

    if ($acl->isAllowed($user, 'page', 'edit')) {
        echo 'Yes.<br /><br />';
    } else {
        echo 'No.<br /><br />';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
