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

    $html = <<<HTMLMSG
<html>
<head>
    <title>
        Test HTML Email
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <h1>Hello [{name}]</h1>
    <p>
        I'm just trying out this new Pop Mail Library component.
    </p>
    <p>
        Thanks,<br />
        Bob
    </p>
</body>
</html>

HTMLMSG;

    $mail = new Mail('Hello World!', $rcpts);
    $mail->from('bob123@gmail.com', 'Bob')
         ->setHeaders(array(
            'X-Mailer'    => 'PHP/' . phpversion(),
            'X-Priority'  => '3',
         ));

    $mail->setText("Hello [{name}],\n\nI'm just trying out this new Pop Mail component.\n\nThanks,\nBob\n\n");
    $mail->setHtml($html);
    $mail->attachFile('../assets/files/test.pdf');
    $mail->send();

    echo 'Mail Sent!';
} catch (\Exception $e) {
    echo $e->getMessage();
}

