<?php

require_once '../../bootstrap.php';

use Pop\Log\Logger,
    Pop\Log\Writer\Mail,
    Pop\Log\Writer\File;


try {
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
    $logger->emerg('Yo stuff is whack man!', $options)
           ->info("Here's some, yo, you know, info stuff", $options);

    echo 'Done';
} catch (\Exception $e) {
    echo $e->getMessage();
}

