<?php

require_once '../../bootstrap.php';

use Pop\Log;
use Pop\Log\Writer;

try {
    $emails = array(
        'Bob Smith'   => 'bob@smith.com',
        'Bubba Smith' => 'bubba@smith.com'
    );

    $options = array(
        'subject' => 'Test App Log Entry:',
        'headers' => array(
            'From'       => 'Test App Logger <logger@testapp.com>',
            'Reply-To'   => 'Test App Logger <logger@testapp.com>',
            'X-Mailer'   => 'PHP/' . phpversion(),
            'X-Priority' => '3',
        )
    );

    $logger = new Log\Logger(new Writer\Mail($emails));
    $logger->addWriter(new Writer\File('../tmp/app.log'));
    $logger->emerg('Yo stuff is whack man!', $options)
           ->info("Here's some, yo, you know, info stuff", $options);

    echo 'Done.';
} catch (\Exception $e) {
    echo $e->getMessage();
}

