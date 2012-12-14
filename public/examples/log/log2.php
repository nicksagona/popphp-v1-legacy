<?php

require_once '../../bootstrap.php';

use Pop\Db\Db as PopDb,
    Pop\Log\Logger,
    Pop\Log\Writer\Db,
    Pop\Log\Writer\File,
    Pop\Record\Record;

class Logs extends Record {}

Logs::setDb(PopDb::factory('Sqlite', array('database' => '../tmp/log.sqlite')));

try {
    $logger = new Logger(new Db(new Logs()));
    $logger->addWriter(new File('../tmp/app.log'));
    $logger->emerg('Yo stuff is whack man!')
           ->info("Here's some, yo, you know, info stuff");

    echo 'Done';
} catch (\Exception $e) {
    echo $e->getMessage();
}

