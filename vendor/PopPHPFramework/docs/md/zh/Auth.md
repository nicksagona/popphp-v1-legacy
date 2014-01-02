Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

的的Auth组件方便用户的认证和授权证书和角色定义了一组基本的基础上。的认证情况处理，以确定是否允许该用户在所有用户进行身份验证。授权方面处理经过身份验证的用户确定是否有足够的访问被允许在一定的区域内。角色可以很容易地被定义和评估，以确定用户的访问级别。的的Auth组件可以很容易地连接到一个数据库表或者磁盘上的文件，以检索用户凭证和信息。

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
