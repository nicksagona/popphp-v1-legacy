<?php

require_once '../../bootstrap.php';

use Pop\Mail\Mail;

try {
    $rcpts = array(
        array(
    		'name'  => 'Test Smith',
    		'email' => 'test@email.com'
        ),
        array(
    		'name'  => 'Someone Else',
    		'email' => 'someone@email.com'
        )
    );

    $mail = new Mail($rcpts, 'Hello World!');
    $mail->setHeaders(array(
        'From'        => array('name' => 'Bob', 'email' => 'bob123@gmail.com'),
        'Reply-To'    => array('name' => 'Bob', 'email' => 'bob123@gmail.com'),
        'X-Mailer'    => 'PHP/' . phpversion(),
        'X-Priority'  => '3',
    ));

    $mail->setText("Hello [{name}],\n\nI'm just trying out this new Pop Mail component.\n\nThanks,\nBob\n\n");
    $mail->send();

    echo 'Mail Sent!' . PHP_EOL . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage();
}

?>