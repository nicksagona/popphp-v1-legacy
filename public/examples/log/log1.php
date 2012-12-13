<?php

require_once '../../bootstrap.php';

use Pop\Log\Logger,
    Pop\Log\Writer\File;

try {
    $logger = new Logger(new File('../tmp/app.csv'));
    $logger->addWriter(new File('../tmp/app.xml'));
    $logger->emerg('Yo stuff is whack man!', 'And here\'s some extra stuff')
           ->info("Here's some, yo, you know, info stuff");

    echo 'Done';
} catch (\Exception $e) {
    echo $e->getMessage();
}

