Pop PHP Framework
=================

Documentation : Log
-------------------

Home

Ð’Ñ…Ð¾Ð´ ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚ Ð±Ð°Ð·Ð¾Ð²ÑƒÑŽ
Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ð¾Ñ?Ñ‚ÑŒ Ð´Ð»Ñ? Ð·Ð°Ð¿Ð¸Ñ?Ð¸ Ð·Ð°Ð¿Ð¸Ñ?ÐµÐ¹
Ð¶ÑƒÑ€Ð½Ð°Ð»Ð° Ð² Ñ€Ð°Ð·Ð»Ð¸Ñ‡Ð½Ñ‹Ñ… Ñ„Ð¾Ñ€Ð¼Ð°Ñ…, Ð² Ñ‚Ð¾Ð¼ Ñ‡Ð¸Ñ?Ð»Ðµ
Ð·Ð°Ð¿Ð¸Ñ?Ð¸ Ð² Ñ„Ð°Ð¹Ð», Ð²Ñ?Ñ‚Ð°Ð²Ð»Ñ?Ñ? Ð² Ð±Ð°Ð·Ðµ Ð´Ð°Ð½Ð½Ñ‹Ñ…
Ð¸Ð»Ð¸ Ñ?Ð»ÐµÐºÑ‚Ñ€Ð¾Ð½Ð½Ð¾Ð¹ Ð¿Ð¾Ñ‡Ñ‚Ðµ, Ð¸Ð»Ð¸ Ð»ÑŽÐ±Ð¾Ð¹ Ñ?Ð¼ÐµÑ?Ð¸
Ð¸Ð· Ð½Ð¸Ñ….

Ð’Ð¾Ñ‚ Ð¿Ñ€Ð¸Ð¼ÐµÑ€ Ð·Ð°Ð¿Ð¸Ñ?Ð¸ Ð² Ñ„Ð°Ð¹Ð» Ð¶ÑƒÑ€Ð½Ð°Ð»Ð°:

    use Pop\Log\Logger,
        Pop\Log\Writer\File;

    $logger = new Logger(new File('../tmp/app.log'));
    $logger->addWriter(new File('../tmp/app.xml'));
    $logger->emerg('Here is an emergency message.')
           ->info('Here is an info message.');

Ð’Ð¾Ñ‚ Ð¿Ñ€Ð¸Ð¼ÐµÑ€ Ð·Ð°Ð¿Ð¸Ñ?Ð¸ Ð² Ð±Ð°Ð·Ðµ Ð´Ð°Ð½Ð½Ñ‹Ñ…:

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

Ð’Ð¾Ñ‚ Ð¿Ñ€Ð¸Ð¼ÐµÑ€ Ð¾Ñ‚Ð¿Ñ€Ð°Ð²ÐºÐ¸ Ð¿Ð¾ Ñ?Ð»ÐµÐºÑ‚Ñ€Ð¾Ð½Ð½Ð¾Ð¹
Ð¿Ð¾Ñ‡Ñ‚Ðµ:

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
