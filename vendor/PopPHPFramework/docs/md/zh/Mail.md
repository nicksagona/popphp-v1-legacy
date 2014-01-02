Pop PHP Framework
=================

Documentation : Mail
--------------------

Home

邮件组件提供了必要的管理外发邮件通过PHP的功能。这包括基于文本和基于HTML的电子邮件，多个邮件收件人，模板和文件附件的支持。

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

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
