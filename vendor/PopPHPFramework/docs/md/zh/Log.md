Pop PHP Framework
=================

Documentation : Log
-------------------

Home

æ—¥å¿—ç»„ä»¶æ??ä¾›äº†å¤šç§?æ–¹å¼?ï¼ŒåŒ…æ‹¬è®°å½•æ—¥å¿—æ?¡ç›®å†™å…¥æ–‡ä»¶ï¼Œæ?’å…¥åˆ°æ•°æ?®åº“ä¸­ï¼Œæˆ–å?‘é€?ç”µå­?é‚®ä»¶ï¼Œæˆ–ä»»ä½•æ··å?ˆç‰©ï¼Œå…¶ä¸­çš„åŸºæœ¬åŠŸèƒ½ã€‚

ä¸‹é?¢æ˜¯ä¸€ä¸ªä¾‹å­?å†™å…¥åˆ°æ—¥å¿—æ–‡ä»¶ä¸­ï¼š

    use Pop\Log\Logger,
        Pop\Log\Writer\File;

    $logger = new Logger(new File('../tmp/app.log'));
    $logger->addWriter(new File('../tmp/app.xml'));
    $logger->emerg('Here is an emergency message.')
           ->info('Here is an info message.');

å†™å…¥åˆ°æ•°æ?®åº“ä¸‹é?¢æ˜¯ä¸€ä¸ªä¾‹å­?ï¼š

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

ä¸‹é?¢æ˜¯ä¸€ä¸ªä¾‹å­?ï¼Œå?‘é€?ç”µå­?é‚®ä»¶ï¼š

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
