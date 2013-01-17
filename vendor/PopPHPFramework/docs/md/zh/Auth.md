Pop PHP Framework
=================

Documentation : Auth
--------------------

Auth组件方便的基础上，凭证和定义的角色的一套基本的用户身份验证和授权。认证方面的处理，以确定是否允许该用户在所有用户进行身份验证。授权方面的处理决定或不经过身份验证的用户是否有足够的访问一定范围内允许的。角色可以很容易地定义和评估，以确定用户的访问级别。 Auth组件可以很容易地连接到数据库表或磁盘上的文件，以获取用户凭据和信息。

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

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
