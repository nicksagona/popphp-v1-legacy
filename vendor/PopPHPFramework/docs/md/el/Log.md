Pop PHP Framework
=================

Documentation : Log
-------------------

Home

Î— ÏƒÏ…Î½Î¹ÏƒÏ„ÏŽÏƒÎ± Ï„Î·Ï‚ ÎºÎ±Ï„Î±Î³Ï?Î±Ï†Î®Ï‚ Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Ï„Î¹Ï‚
Î²Î±ÏƒÎ¹ÎºÎ­Ï‚ Î»ÎµÎ¹Ï„Î¿Ï…Ï?Î³Î¯ÎµÏ‚ Î³Î¹Î± Ï„Î·Î½ ÎºÎ±Ï„Î±Î³Ï?Î±Ï†Î®
ÏƒÎµ Î·Î¼ÎµÏ?Î¿Î»ÏŒÎ³Î¹Î¿ ÎºÎ±Ï„Î±Ï‡Ï‰Ï?Î®ÏƒÎµÎ¹Ï‚ Î¼Îµ
Î´Î¹Î¬Ï†Î¿Ï?Î¿Ï…Ï‚ Ï„Ï?ÏŒÏ€Î¿Ï…Ï‚,
ÏƒÏ…Î¼Ï€ÎµÏ?Î¹Î»Î±Î¼Î²Î±Î½Î¿Î¼Î­Î½Î·Ï‚ Ï„Î·Ï‚ Î³Ï?Î±Ï†Î®Ï‚ ÏƒÏ„Î¿
Î±Ï?Ï‡ÎµÎ¯Î¿, ÎµÎ¹ÏƒÎ±Î³Ï‰Î³Î® ÏƒÎµ Î¼Î¹Î± Î²Î¬ÏƒÎ· Î´ÎµÎ´Î¿Î¼Î­Î½Ï‰Î½
Î® ÏƒÏ„Î­Î»Î½Î¿Î½Ï„Î±Ï‚ Î­Î½Î± e-mail, Î® Î¿Ï€Î¿Î¹Î¿Î´Î®Ï€Î¿Ï„Îµ
Î¼Î¯Î³Î¼Î± Ï„Î¿Ï…Ï‚.

Î•Î´ÏŽ ÎµÎ¯Î½Î±Î¹ Î­Î½Î± Ï€Î±Ï?Î¬Î´ÎµÎ¹Î³Î¼Î± Ï„Î·Ï‚ Î³Ï?Î±Ï†Î®Ï‚ ÏƒÎµ
Î­Î½Î± Î±Ï?Ï‡ÎµÎ¯Î¿ ÎºÎ±Ï„Î±Î³Ï?Î±Ï†Î®Ï‚:

    use Pop\Log\Logger,
        Pop\Log\Writer\File;

    $logger = new Logger(new File('../tmp/app.log'));
    $logger->addWriter(new File('../tmp/app.xml'));
    $logger->emerg('Here is an emergency message.')
           ->info('Here is an info message.');

Î•Î´ÏŽ ÎµÎ¯Î½Î±Î¹ Î­Î½Î± Ï€Î±Ï?Î¬Î´ÎµÎ¹Î³Î¼Î± Ï„Î·Ï‚ Î³Ï?Î±Ï†Î®Ï‚ ÏƒÎµ
Î¼Î¹Î± Î²Î¬ÏƒÎ· Î´ÎµÎ´Î¿Î¼Î­Î½Ï‰Î½:

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

Î•Î´ÏŽ ÎµÎ¯Î½Î±Î¹ Î­Î½Î± Ï€Î±Ï?Î¬Î´ÎµÎ¹Î³Î¼Î± ÏƒÏ„Î­Î»Î½Î¿Î½Ï„Î±Ï‚
Î­Î½Î± e-mail:

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
