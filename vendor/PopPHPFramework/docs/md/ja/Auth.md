Pop PHP Framework
=================

Documentation : Auth
--------------------

Authコンポーネントは、資格情報と定義されたロールの基本セットに基づいてユーザーの認証と認可を容易にします。認証アスペクトが、ユーザーがまったく許可されているかどうかを判断するためにユーザを認証して処理します。認可の側面は、認証されたユーザーが十分な特定のエリア内に許可するアクセスしたかどうかを判定する処理します。役割は簡単に定義して、アクセスユーザのレベルを決定するために評価することができます。 Authコンポーネントは、簡単にユーザーの資格情報を取得するために、データベースのテーブルやディスク上のファイルに結び付けることができます。

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
