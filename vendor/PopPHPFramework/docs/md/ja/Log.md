Pop PHP Framework
=================

Documentation : Log
-------------------

Home

ãƒ­ã‚°ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?ãƒ‡ãƒ¼ã‚¿ãƒ™ãƒ¼ã‚¹ã?«æŒ¿å…¥ã?—ã?Ÿã‚Šã€?é›»å­?ãƒ¡ãƒ¼ãƒ«ã€?ã?¾ã?Ÿã?¯ã??ã‚Œã‚‰ã?®ä»»æ„?ã?®æ··å?ˆç‰©ã‚’é€?ä¿¡ã?—ã€?ãƒ•ã‚¡ã‚¤ãƒ«ã?¸ã?®æ›¸ã??è¾¼ã?¿ã?ªã?©ã€?ã?•ã?¾ã?–ã?¾ã?ªæ–¹æ³•ã?§ãƒ­ã‚°ã‚¨ãƒ³ãƒˆãƒªã‚’è¨˜éŒ²ã?™ã‚‹ã?Ÿã‚?ã?®åŸºæœ¬çš„ã?ªæ©Ÿèƒ½ã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚

ã?“ã?“ã?§ã?¯ã€?ãƒ­ã‚°ãƒ•ã‚¡ã‚¤ãƒ«ã?¸ã?®æ›¸ã??è¾¼ã?¿ã?®ä¾‹ã?¯æ¬¡ã?®ã?¨ã?Šã‚Šã?§ã?™ã€‚

    use Pop\Log\Logger,
        Pop\Log\Writer\File;

    $logger = new Logger(new File('../tmp/app.log'));
    $logger->addWriter(new File('../tmp/app.xml'));
    $logger->emerg('Here is an emergency message.')
           ->info('Here is an info message.');

ã?“ã?“ã?«ãƒ‡ãƒ¼ã‚¿ãƒ™ãƒ¼ã‚¹ã?¸ã?®æ›¸ã??è¾¼ã?¿ã?®ä¾‹ã?§ã?™ï¼š

    use Pop\Db\Db as PopDb,
        Pop\Log\Logger,
        Pop\Log\Writer\Db,
        Pop\Log\Writer\File,
        Pop\Record\Record;

    class Logs extends Record {}

    Logs::setDb(PopDb::factory('Sqlite', array('database' => '../tmp/log.sqlite')));

    $logger = new Logger(new Db(new Logs()));
    $logger->addWriter(new File('../tmp/app.log'));
    $logger->emerg('Here is an emergency message.')
           ->info('Here is an info message.');

ã?“ã?“ã?«é›»å­?ãƒ¡ãƒ¼ãƒ«ã‚’é€?ä¿¡ã?™ã‚‹ä¾‹ã‚’ç¤ºã?—ã?¾ã?™ï¼š

    use Pop\Log\Logger,
        Pop\Log\Writer\Mail,
        Pop\Log\Writer\File;

    $emails = array(
        'Bob Smith'   => 'bob@smith.com',
        'Bubba Smith' => 'bubba@smith.com'
    );

    $options = array(
        'subject' => 'Test App Log Entry:',
        'headers' => array(
            'From'       => array('name' => 'Test App Logger', 'email' => 'logger@testapp.com'),
            'Reply-To'   => array('name' => 'Test App Logger', 'email' => 'logger@testapp.com'),
            'X-Mailer'   => 'PHP/' . phpversion(),
            'X-Priority' => '3',
        )
    );

    $logger = new Logger(new Mail($emails));
    $logger->addWriter(new File('../tmp/app.log'));
    $logger->emerg('Here is an emergency message.', $options)
           ->info('Here is an info message.', $options);

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
