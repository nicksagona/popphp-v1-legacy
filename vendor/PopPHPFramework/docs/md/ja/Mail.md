Pop PHP Framework
=================

Documentation : Mail
--------------------

Home

ãƒ¡ãƒ¼ãƒ«ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?PHPçµŒç”±ã?§é€?ä¿¡ãƒ¡ãƒ¼ãƒ«ã‚’ç®¡ç?†ã?™ã‚‹ã?Ÿã‚?ã?«å¿…è¦?ã?ªæ©Ÿèƒ½ã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚ã?“ã‚Œã?¯ã€?ãƒ†ã‚­ã‚¹ãƒˆãƒ™ãƒ¼ã‚¹ã?Šã‚ˆã?³HTMLãƒ™ãƒ¼ã‚¹ã?®é›»å­?ãƒ¡ãƒ¼ãƒ«ã?¯ã€?è¤‡æ•°ã?®ãƒ¡ãƒ¼ãƒ«å?—ä¿¡ã€?ãƒ†ãƒ³ãƒ—ãƒ¬ãƒ¼ãƒˆã‚„æ·»ä»˜ãƒ•ã‚¡ã‚¤ãƒ«ã?®ã‚µãƒ?ãƒ¼ãƒˆã?Œå?«ã?¾ã‚Œã?¾ã?™ã€‚

    use Pop\Mail\Mail;

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
    $mail->send();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
