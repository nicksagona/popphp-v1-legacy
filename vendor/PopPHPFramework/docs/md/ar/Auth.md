Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† Ø§Ù„Ù…ØµØ§Ø¯Ù‚Ø© ÙŠØ³Ù‡Ù„ Ø§Ù„ØªÙˆØ«ÙŠÙ‚ ÙˆØ§Ù„Ø¥Ø°Ù† Ù…Ù†
Ø§Ù„Ù…Ø³ØªØ®Ø¯Ù…ÙŠÙ† Ø¨Ù†Ø§Ø¡ Ø¹Ù„Ù‰ Ù…Ø¬Ù…ÙˆØ¹Ø© Ø£Ø³Ø§Ø³ÙŠØ© Ù…Ù†
ÙˆØ«Ø§Ø¦Ù‚ Ø§Ù„ØªÙ?ÙˆÙŠØ¶ ÙˆØ£Ø¯ÙˆØ§Ø± Ù…Ø­Ø¯Ø¯Ø©. ÙŠØ¹Ø§Ù„Ø¬
Ø§Ù„Ø¬Ø§Ù†Ø¨ Ø§Ù„Ù…ØµØ§Ø¯Ù‚Ø© Ù…ØµØ§Ø¯Ù‚Ø© Ù…Ø³ØªØ®Ø¯Ù… Ù„ØªØ­Ø¯ÙŠØ¯
Ù…Ø§ Ø¥Ø°Ø§ ÙƒØ§Ù† Ø£Ùˆ Ù„Ø§ ÙŠØ³Ù…Ø­ Ù‡Ø°Ø§ Ø§Ù„Ù…Ø³ØªØ®Ø¯Ù… Ø¹Ù„Ù‰
Ø§Ù„Ø¥Ø·Ù„Ø§Ù‚. Ø¥Ø°Ù† Ø§Ù„Ø¬Ø§Ù†Ø¨ Ù…Ù‚Ø§Ø¨Ø¶ ØªØ­Ø¯ÙŠØ¯ Ù…Ø§ Ø¥Ø°Ø§
ÙƒØ§Ù† Ø£Ùˆ Ù„Ù… ÙŠÙƒÙ† Ù„Ø¯ÙŠÙ‡ Ø­Ù‚ Ø§Ù„ÙˆØµÙˆÙ„ Ù…ØµØ§Ø¯Ù‚Ø©
Ø§Ù„Ù…Ø³ØªØ®Ø¯Ù… Ø¨Ù…Ø§ Ù?ÙŠÙ‡ Ø§Ù„ÙƒÙ?Ø§ÙŠØ© Ù„ÙŠØ³Ù…Ø­ Ø¯Ø§Ø®Ù„
Ù…Ù†Ø·Ù‚Ø© Ù…Ø¹ÙŠÙ†Ø©. ÙŠÙ…ÙƒÙ†Ùƒ Ø¨Ø³Ù‡ÙˆÙ„Ø© Ø£Ù† ØªØ¹Ø±Ù?
Ø§Ù„Ø£Ø¯ÙˆØ§Ø± ÙˆØªÙ‚ÙŠÙŠÙ…Ù‡Ø§ Ù„ØªØ­Ø¯ÙŠØ¯ Ù…Ø³ØªÙˆÙ‰ Ø§Ù„Ù…Ø³ØªØ®Ø¯Ù…
Ù…Ù† Ø§Ù„ÙˆØµÙˆÙ„. ÙŠÙ…ÙƒÙ† Ø±Ø¨Ø· Ø¹Ù†ØµØ± Ø£ØµÙŠÙ„ Ø¨Ø³Ù‡ÙˆÙ„Ø© Ù?ÙŠ
Ø¬Ø¯ÙˆÙ„ Ù‚Ø§Ø¹Ø¯Ø© Ø¨ÙŠØ§Ù†Ø§Øª Ø£Ùˆ Ù…Ù„Ù? Ø¹Ù„Ù‰ Ø§Ù„Ù‚Ø±Øµ
Ù„Ø§Ø³ØªØ±Ø¯Ø§Ø¯ Ø£ÙˆØ±Ø§Ù‚ Ø§Ø¹ØªÙ…Ø§Ø¯ Ø§Ù„Ù…Ø³ØªØ®Ø¯Ù…
ÙˆØ§Ù„Ù…Ø¹Ù„ÙˆÙ…Ø§Øª.

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
