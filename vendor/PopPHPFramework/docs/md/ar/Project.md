Pop PHP Framework
=================

Documentation : Project
-----------------------

Home

Ø£Ù…Ø§ Ø¹Ù†ØµØ± Ø§Ù„Ù…Ø´Ø±ÙˆØ¹ ÙŠØ­ØªÙˆÙŠ Ø¹Ù„Ù‰ Ø§Ù„Ù?Ø¦Ø©
Ø§Ù„Ù…Ø´Ø±ÙˆØ¹ Ø§Ù„Ø°ÙŠ ÙŠÙ…ÙƒÙ†Ùƒ ØªÙˆØ³ÙŠØ¹ ÙˆØªØºÙ„ÙŠÙ?
Ù…ÙˆØ§ØµÙ?Ø§Øª Ø§Ù„ØªØ·Ø¨ÙŠÙ‚ Ø§Ù„Ø®Ø§Øµ Ø¨ÙƒØŒ Ù…Ø«Ù„ Ø¬Ù‡Ø§Ø²
Ø§Ù„ØªÙˆØ¬ÙŠÙ‡ØŒ ÙˆØ£Ø¬Ù‡Ø²Ø© Ø§Ù„ØªØ­ÙƒÙ… ÙˆÙ‚ÙˆØ§Ø¹Ø¯ Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª
ÙˆØ§Ù„ÙˆØ­Ø¯Ø§Øª Ø§Ù„Ù†Ù…Ø·ÙŠØ©. Ù…Ø±Ø© ÙˆØ§Ø­Ø¯Ø©ØŒ Ø¥Ø¹Ø¯Ø§Ø¯ Ø¨Ø´ÙƒÙ„
ØµØ­ÙŠØ­ØŒ ÙŠÙ…ÙƒÙ† Ù„Ù„Ù…Ø´Ø±ÙˆØ¹ "ØªØ´ØºÙŠÙ„" ÙˆØ§Ù„Ø·Ø±ÙŠÙ‚
Ø¨Ù†Ø¬Ø§Ø­ Ø·Ù„Ø¨ Ø§Ù„Ù…Ø³ØªØ®Ø¯Ù… Ø¥Ù„Ù‰ Ø§Ù„Ù…Ù†Ø·Ù‚Ø© Ø§Ù„ØµØ­ÙŠØ­Ø©
Ù…Ù† Ø§Ù„ØªØ·Ø¨ÙŠÙ‚ Ø§Ù„Ø®Ø§Øµ Ø¨Ùƒ. Ø¹Ø±Ø¶ Ø§Ù„Ù…Ù„Ù? MVC Ø«ÙŠÙ‚Ø©
Ù…ÙƒÙˆÙ† Ù„Ù…Ø´Ø§Ù‡Ø¯Ø© Ù…Ø«Ø§Ù„ Ù…Ù† Ù…Ù„Ù? Ù…Ø´Ø±ÙˆØ¹ Ù?Ø¦Ø©
Ø§Ù„Ù…ÙˆØ³Ø¹Ø©.

Ø£ÙŠØ¶Ø§ØŒ ÙˆØ¹Ù†ØµØ± Ù…Ù† Ø¹Ù†Ø§ØµØ± Ø§Ù„Ù…Ø´Ø±ÙˆØ¹ ÙŠØ­ØªÙˆÙŠ Ø¹Ù„Ù‰
Ø¯Ø±ÙˆØ³ ØªØ«Ø¨ÙŠØª Ù‡Ø°Ø§ Ø§Ù„Ù…ÙƒÙˆÙ† CLI ÙŠØ³ØªØ®Ø¯Ù… Ù„Ø¨Ù†Ø§Ø¡
ÙˆØªØ«Ø¨ÙŠØª Ø§Ù„Ø³Ù‚Ø§Ù„Ø§Øª Ø§Ù„Ù…Ø´Ø±ÙˆØ¹. Ù…Ø«Ø§Ù„ Ø¹Ù„Ù‰ ØªÙƒÙˆÙŠÙ†
Ù…Ù„Ù? Ø§Ù„Ù…Ø´Ø±ÙˆØ¹ Ù‡Ùˆ ØªØ«Ø¨ÙŠØª Ø£Ø¯Ù†Ø§Ù‡.

    <?php
    return new Pop\Config(array(
        'project' => array(
            'name'    => 'HelloWorld',
            'base'    => __DIR__ . '/../../',
            'docroot' => __DIR__ . '/../../public'
        ),
        'databases' => array(
            'helloworld' => array(
                'type'     => 'Mysqli',
                'database' => 'helloworld',
                'host'     => 'localhost',
                'username' => 'hello',
                'password' => '12world34',
                'prefix'   => 'pop_',
                'default'  => true
            )
        ),
        'forms' => array(
            'login' => array(
                'fields' => array(
                    array(
                        'type'       => 'text',
                        'name'       => 'username',
                        'label'      => 'Username:',
                        'required'   => true,
                        'attributes' => array('size', 40),
                        'validators' => 'AlphaNumeric()'
                    ),
                    array(
                        'type'       => 'password',
                        'name'       => 'password',
                        'label'      => 'Password:',
                        'required'   => true,
                        'attributes' => array('size', 40),
                        'validators' => array('NotEmpty()', 'LengthGt(6)')
                    ),
                    array(
                        'type'       => 'submit',
                        'name'       => 'submit',
                        'value'      => 'LOGIN'
                    )
                )
            )
        ),
        'controllers' => array(
            '/' => array(
                'index' => 'index.phtml',
                'error' => 'error.phtml'
            ),
            '/admin' => array(
                'index' => 'index.phtml',
                'error' => 'error.phtml'
            )
        )
    ));

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
