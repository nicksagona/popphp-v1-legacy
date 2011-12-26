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

    $mail = new Mail($rcpts, 'Hello World!');
    $mail->setHeaders(array(
        'From'        => array('name' => 'Bob', 'email' => 'bob123@gmail.com'),
        'Reply-To'    => array('name' => 'Bob', 'email' => 'bob123@gmail.com'),
        'X-Mailer'    => 'PHP/' . phpversion(),
        'X-Priority'  => '3',
    ));

    $mail->setText("Hello [{name}],\n\nI'm just trying out this new Pop Mail component.\n\nThanks,\nBob\n\n");
    $mail->setHtml($html);
    $mail->send();

    echo 'Mail Sent!' . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>