Pop PHP Framework
=================

Documentation : Log
--------------------

Вход компонент предоставляет базовую функциональность для записи записей журнала в различных формах, в том числе записи в файл, вставляя в базе данных или электронной почте, или любой смеси из них.

Вот пример записи в файл журнала:

<pre>
use Pop\Log\Logger,
    Pop\Log\Writer\File;

$logger = new Logger(new File('../tmp/app.log'));
$logger-&gt;addWriter(new File('../tmp/app.xml'));
$logger-&gt;emerg('Here is an emergency message.')
       -&gt;info('Here is an info message.');
</pre>

Вот пример записи в базе данных:

<pre>
use Pop\Db\Db as PopDb,
    Pop\Log\Logger,
    Pop\Log\Writer\Db,
    Pop\Log\Writer\File,
    Pop\Record\Record;

class Logs extends Record {}

Logs::setDb(PopDb::factory('Sqlite', array('database' =&gt; '../tmp/log.sqlite')));

$logger = new Logger(new Db(new Logs()));
$logger-&gt;addWriter(new File('../tmp/app.log'));
$logger-&gt;emerg('Here is an emergency message.')
       -&gt;info('Here is an info message.');
</pre>

Вот пример отправки по электронной почте:

<pre>
use Pop\Log\Logger,
    Pop\Log\Writer\Mail,
    Pop\Log\Writer\File;

$emails = array(
    'Bob Smith'   =&gt; 'bob@smith.com',
    'Bubba Smith' =&gt; 'bubba@smith.com'
);

$options = array(
    'subject' =&gt; 'Test App Log Entry:',
    'headers' =&gt; array(
        'From'       =&gt; array('name' =&gt; 'Test App Logger', 'email' =&gt; 'logger@testapp.com'),
        'Reply-To'   =&gt; array('name' =&gt; 'Test App Logger', 'email' =&gt; 'logger@testapp.com'),
        'X-Mailer'   =&gt; 'PHP/' . phpversion(),
        'X-Priority' =&gt; '3',
    )
);

$logger = new Logger(new Mail($emails));
$logger-&gt;addWriter(new File('../tmp/app.log'));
$logger-&gt;emerg('Here is an emergency message.', $options)
       -&gt;info('Here is an info message.', $options);
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
