Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

Authコンポーネントは、資格情報と定義されたロールの基本セットに基づいて、ユーザーの認証と認可を容易にします。認証アスペクトが、そのユーザが全く許可されているかどうかを決定するためにユーザを認証する処理します。認可の側面は、認証されたユーザーが十分な特定の領域内では許可されなければアクセスしているか否かを判定する処理します。ロールは簡単に​​定義し、ユーザーのアクセスレベルを決定するために評価することができます。
Authコンポーネントは、簡単にユーザーの資格情報を取得するために、データベース·テーブルまたはディスク上のファイルに結合することができます。

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
