<?php

require_once '../../bootstrap.php';

use Pop\Db\Db as PopDb,
    Pop\Log\Logger,
    Pop\Log\Writer\Db,
    Pop\Record\Record;

class Log extends Record {}

Log::setDb(PopDb::factory('Sqlite', array('database' => '../tmp/log.sqlite')));

try {
    $logger = new Logger(new Db(new Log()));
    $logger->emerg('Yo stuff is whack man!', 'And here\'s some extra stuff')
           ->info("Here's some, yo, you know, info stuff");

    echo 'Done';
} catch (\Exception $e) {
    echo $e->getMessage();
}

