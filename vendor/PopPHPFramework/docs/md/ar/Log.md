Pop PHP Framework
=================

Documentation : Log
-------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† Ø¯Ø®ÙˆÙ„ ÙŠÙˆÙ?Ø± ÙˆØ¸Ø§Ø¦Ù? Ø£Ø³Ø§Ø³ÙŠØ© Ù„ØªØ³Ø¬ÙŠÙ„
Ø¥Ø¯Ø®Ø§Ù„Ø§Øª Ø³Ø¬Ù„ Ù?ÙŠ Ù…Ø¬Ù…ÙˆØ¹Ø© Ù…ØªÙ†ÙˆØ¹Ø© Ù…Ù† Ø§Ù„Ø·Ø±Ù‚ØŒ
Ø¨Ù…Ø§ Ù?ÙŠ Ø°Ù„Ùƒ ÙƒØªØ§Ø¨Ø© Ø¥Ù„Ù‰ Ù…Ù„Ù?ØŒ ÙˆØ¥Ø¯Ø±Ø§Ø¬ Ù?ÙŠ
Ù‚Ø§Ø¹Ø¯Ø© Ø¨ÙŠØ§Ù†Ø§Øª Ø£Ùˆ Ø¥Ø±Ø³Ø§Ù„ Ø±Ø³Ø§Ù„Ø© Ø¨Ø±ÙŠØ¯
Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠØŒ Ø£Ùˆ Ø£ÙŠ Ù…Ø²ÙŠØ¬ Ù…Ù†Ù‡Ø§.

ÙˆÙ‡Ù†Ø§ Ù…Ø«Ø§Ù„ Ø¹Ù„Ù‰ ÙƒØªØ§Ø¨Ø© Ø¥Ù„Ù‰ Ù…Ù„Ù? Ø³Ø¬Ù„:

    use Pop\Log\Logger,
        Pop\Log\Writer\File;

    $logger = new Logger(new File('../tmp/app.log'));
    $logger->addWriter(new File('../tmp/app.xml'));
    $logger->emerg('Here is an emergency message.')
           ->info('Here is an info message.');

ÙˆÙ‡Ù†Ø§ Ù…Ø«Ø§Ù„ Ø¹Ù„Ù‰ Ø§Ù„ÙƒØªØ§Ø¨Ø© Ø¥Ù„Ù‰ Ù‚Ø§Ø¹Ø¯Ø©
Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª:

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

ÙˆÙ‡Ù†Ø§ Ù…Ø«Ø§Ù„ Ø¹Ù„Ù‰ Ø§Ø±Ø³Ø§Ù„ Ø¨Ø§Ù„Ø¨Ø±ÙŠØ¯ Ø§Ù„Ø§Ù„ÙƒØªØ±ÙˆÙ†ÙŠ:

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
