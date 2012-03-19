Pop PHP Framework
=================

Documentation : Auth
--------------------

Il componente Auth facilita l'autenticazione e l'autorizzazione degli utenti sulla base di un set di base di credenziali e ruoli definiti. L'aspetto di autenticazione gestisce l'autenticazione di un utente per determinare se l'utente è consentito a tutti. L'aspetto autorizzazione gestisce determinare se l'utente autenticato ha abbastanza di poter accedere all'interno di una determinata area. I ruoli possono essere facilmente definiti e valutati per determinare il livello di un utente di accesso. Il componente Auth può facilmente legare in una tabella di database o un file su disco per recuperare le credenziali dell'utente e le informazioni.

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
