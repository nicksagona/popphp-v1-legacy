Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

Authã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?è³‡æ ¼æƒ…å
±ã?¨å®šç¾©ã?•ã‚Œã?Ÿãƒ­ãƒ¼ãƒ«ã?®åŸºæœ¬ã‚»ãƒƒãƒˆã?«åŸºã?¥ã?„ã?¦ã€?ãƒ¦ãƒ¼ã‚¶ãƒ¼ã?®èª?è¨¼ã?¨èª?å?¯ã‚’å®¹æ˜“ã?«ã?—ã?¾ã?™ã€‚èª?è¨¼ã‚¢ã‚¹ãƒšã‚¯ãƒˆã?Œã€?ã??ã?®ãƒ¦ãƒ¼ã‚¶ã?Œå…¨ã??è¨±å?¯ã?•ã‚Œã?¦ã?„ã‚‹ã?‹ã?©ã?†ã?‹ã‚’æ±ºå®šã?™ã‚‹ã?Ÿã‚?ã?«ãƒ¦ãƒ¼ã‚¶ã‚’èª?è¨¼ã?™ã‚‹å‡¦ç?†ã?—ã?¾ã?™ã€‚èª?å?¯ã?®å?´é?¢ã?¯ã€?èª?è¨¼ã?•ã‚Œã?Ÿãƒ¦ãƒ¼ã‚¶ãƒ¼ã?Œå??åˆ†ã?ªç‰¹å®šã?®é
˜åŸŸå†…ã?§ã?¯è¨±å?¯ã?•ã‚Œã?ªã?‘ã‚Œã?°ã‚¢ã‚¯ã‚»ã‚¹ã?—ã?¦ã?„ã‚‹ã?‹å?¦ã?‹ã‚’åˆ¤å®šã?™ã‚‹å‡¦ç?†ã?—ã?¾ã?™ã€‚ãƒ­ãƒ¼ãƒ«ã?¯ç°¡å?˜ã?«â€‹â€‹å®šç¾©ã?—ã€?ãƒ¦ãƒ¼ã‚¶ãƒ¼ã?®ã‚¢ã‚¯ã‚»ã‚¹ãƒ¬ãƒ™ãƒ«ã‚’æ±ºå®šã?™ã‚‹ã?Ÿã‚?ã?«è©•ä¾¡ã?™ã‚‹ã?“ã?¨ã?Œã?§ã??ã?¾ã?™ã€‚
Authã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?ç°¡å?˜ã?«ãƒ¦ãƒ¼ã‚¶ãƒ¼ã?®è³‡æ ¼æƒ…å
±ã‚’å?–å¾—ã?™ã‚‹ã?Ÿã‚?ã?«ã€?ãƒ‡ãƒ¼ã‚¿ãƒ™ãƒ¼ã‚¹Â·ãƒ†ãƒ¼ãƒ–ãƒ«ã?¾ã?Ÿã?¯ãƒ‡ã‚£ã‚¹ã‚¯ä¸Šã?®ãƒ•ã‚¡ã‚¤ãƒ«ã?«çµ?å?ˆã?™ã‚‹ã?“ã?¨ã?Œã?§ã??ã?¾ã?™ã€‚

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
