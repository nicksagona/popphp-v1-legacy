Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

çš„çš„Authç»„ä»¶æ–¹ä¾¿ç”¨æˆ·çš„è®¤è¯?å’ŒæŽˆæ?ƒè¯?ä¹¦å’Œè§’è‰²å®šä¹‰äº†ä¸€ç»„åŸºæœ¬çš„åŸºç¡€ä¸Šã€‚çš„è®¤è¯?æƒ…å†µå¤„ç?†ï¼Œä»¥ç¡®å®šæ˜¯å?¦å…?è®¸è¯¥ç”¨æˆ·åœ¨æ‰€æœ‰ç”¨æˆ·è¿›è¡Œèº«ä»½éªŒè¯?ã€‚æŽˆæ?ƒæ–¹é?¢å¤„ç?†ç»?è¿‡èº«ä»½éªŒè¯?çš„ç”¨æˆ·ç¡®å®šæ˜¯å?¦æœ‰è¶³å¤Ÿçš„è®¿é—®è¢«å…?è®¸åœ¨ä¸€å®šçš„åŒºåŸŸå†…ã€‚è§’è‰²å?¯ä»¥å¾ˆå®¹æ˜“åœ°è¢«å®šä¹‰å’Œè¯„ä¼°ï¼Œä»¥ç¡®å®šç”¨æˆ·çš„è®¿é—®çº§åˆ«ã€‚çš„çš„Authç»„ä»¶å?¯ä»¥å¾ˆå®¹æ˜“åœ°è¿žæŽ¥åˆ°ä¸€ä¸ªæ•°æ?®åº“è¡¨æˆ–è€…ç£?ç›˜ä¸Šçš„æ–‡ä»¶ï¼Œä»¥æ£€ç´¢ç”¨æˆ·å‡­è¯?å’Œä¿¡æ?¯ã€‚

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
