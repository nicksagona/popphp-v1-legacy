Pop PHP Framework
=================

Documentation : Mail
--------------------

Home

Î— ÏƒÏ…Î½Î¹ÏƒÏ„ÏŽÏƒÎ± Mail Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Ï„Î·Î½ Î±Ï€Î±Ï?Î±Î¯Ï„Î·Ï„Î·
Î»ÎµÎ¹Ï„Î¿Ï…Ï?Î³Î¹ÎºÏŒÏ„Î·Ï„Î± Î³Î¹Î± Ï„Î· Î´Î¹Î±Ï‡ÎµÎ¯Ï?Î¹ÏƒÎ·
ÎµÎ¾ÎµÏ?Ï‡ÏŒÎ¼ÎµÎ½Î·Ï‚ Î±Î»Î»Î·Î»Î¿Î³Ï?Î±Ï†Î¯Î±Ï‚ Î¼Î­ÏƒÏ‰ PHP. Î‘Ï…Ï„ÏŒ
Ï€ÎµÏ?Î¹Î»Î±Î¼Î²Î¬Î½ÎµÎ¹ Ï…Ï€Î¿ÏƒÏ„Î®Ï?Î¹Î¾Î· Î³Î¹Î± Ï„Î¿ ÎºÎµÎ¯Î¼ÎµÎ½Î¿
Ï€Î¿Ï… Î²Î±ÏƒÎ¯Î¶ÎµÏ„Î±Î¹ ÎºÎ±Î¹ HTML-based email, Ï€Î¿Î»Î»Î±Ï€Î»Î¿Ï?Ï‚
Ï€Î±Ï?Î±Î»Î®Ï€Ï„ÎµÏ‚ Î·Î»ÎµÎºÏ„Ï?Î¿Î½Î¹ÎºÎ¿Ï? Ï„Î±Ï‡Ï…Î´Ï?Î¿Î¼ÎµÎ¯Î¿Ï…,
Ï„Î± Ï€Ï?ÏŒÏ„Ï…Ï€Î± ÎºÎ±Î¹ Ï„Î± ÏƒÏ…Î½Î·Î¼Î¼Î­Î½Î± Î±Ï?Ï‡ÎµÎ¯Î±.

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
