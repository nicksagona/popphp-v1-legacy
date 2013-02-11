<?php

require_once '../../bootstrap.php';

use Pop\Log;
use Pop\Log\Writer;

try {
    $logger = new Log\Logger(new Writer\File('../tmp/app.log'));
    $logger->addWriter(new Writer\File('../tmp/app.xml'));
    $logger->emerg('Yo stuff is whack man!')
           ->info("Here's some, yo, you know, info stuff");

    echo 'Done.';
} catch (\Exception $e) {
    echo $e->getMessage();
}

