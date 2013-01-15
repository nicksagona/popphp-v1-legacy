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

    $mail = new Mail('Hello World!', $rcpts);
    $mail->sendAsGroup(true)
         ->from('bob123@gmail.com', 'Bob')
         ->setHeaders(array(
            'X-Mailer'    => 'PHP/' . phpversion(),
            'X-Priority'  => '3',
         ));

    $mail->setText("Hello,\n\nI'm just trying out this new Pop Mail component.\n\nThanks,\nBob\n\n");
    $mail->send();

    echo 'Mail Sent!';
} catch (\Exception $e) {
    echo $e->getMessage();
}

