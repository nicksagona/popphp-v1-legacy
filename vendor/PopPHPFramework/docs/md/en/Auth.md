Pop PHP Framework
=================

Documentation : Auth
--------------------

The Auth component facilitates authentication and authorization of users based on a basic set of credentials and defined roles. The authentication aspect handles authenticating a user to determine whether or not that user is allowed at all. The authorization aspect handles determining whether or not the authenticated user has enough access to be allowed within a certain area. Roles can easily be defined and evaluated to determine a user's level of access. The Auth component can easily tie into a database table or a file on disk to retrieve user credentials and information.

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
