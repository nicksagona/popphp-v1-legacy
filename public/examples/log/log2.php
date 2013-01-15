<?php

require_once '../../bootstrap.php';

use Pop\Db\Db,
    Pop\Record\Record,
    Pop\Log,
    Pop\Log\Writer;

class Logs extends Record {}

Logs::setDb(Db::factory('Sqlite', array('database' => '../tmp/log.sqlite')));

try {
    $logger = new Log\Logger(new Writer\Db(new Logs()));
    $logger->addWriter(new Writer\File('../tmp/app.log'));
    $logger->emerg('Yo stuff is whack man!')
           ->info("Here's some, yo, you know, info stuff");

    echo 'Done.';
} catch (\Exception $e) {
    echo $e->getMessage();
}

