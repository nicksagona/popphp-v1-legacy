Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

Authコンポーネントは、資格情報と定義されたロールの基本セットに基づいて、ユーザーの認証と認可を容易にします。認証アスペクトが、そのユーザが全く許可されているかどうかを決定するためにユーザを認証する処理します。認可の側面は、認証されたユーザーが十分な特定の領域内では許可されなければアクセスしているか否かを判定する処理します。ロールは簡単に​​定義し、ユーザーのアクセスレベルを決定するために評価することができます。
Authコンポーネントは、簡単にユーザーの資格情報を取得するために、データベース·テーブルまたはディスク上のファイルに結合することができます。

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
