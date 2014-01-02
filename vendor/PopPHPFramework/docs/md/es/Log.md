Pop PHP Framework
=================

Documentation : Log
-------------------

Home

El componente de registro proporciona la funcionalidad básica para
registrar las entradas del registro en una variedad de maneras,
incluyendo escribir en el archivo, insertar en una base de datos o el
envío de un correo electrónico, o cualquier mezcla de ellos.

He aquí un ejemplo de cómo escribir un archivo de registro:

    use Pop\Log\Logger,
        Pop\Log\Writer\File;

    $logger = new Logger(new File('../tmp/app.log'));
    $logger->addWriter(new File('../tmp/app.xml'));
    $logger->emerg('Here is an emergency message.')
           ->info('Here is an info message.');

He aquí un ejemplo de cómo escribir una base de datos:

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

He aquí un ejemplo del envío de un correo electrónico:

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

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
