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
    $mail->from('bob123@gmail.com', 'Bob');
    $mail->setText("Hello [{name}],\n\nI'm just trying out this new Pop Mail component.\n\nThanks,\nBob\n\n");

    // Save emails to a file format that can later be sent
    // by the Pop\Mail component or another external email
    // program, such as qmail, sendmail, etc.
    $mail->saveTo('../tmp');

    // Use the Pop\Mail component to send the saved email files.
    //$mail = new Mail();
    //$mail->sendFrom('../tmp', true);

    echo 'Mail Saved!';
} catch (\Exception $e) {
    echo $e->getMessage();
}

