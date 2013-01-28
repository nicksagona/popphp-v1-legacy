Pop PHP Framework
=================

Documentation : Mail
--------------------

Home

ÐŸÐ¾Ñ‡Ñ‚Ð° ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¾Ð±ÐµÑ?Ð¿ÐµÑ‡Ð¸Ð²Ð°ÐµÑ‚
Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ð¾Ñ?Ñ‚ÑŒ, Ð½ÐµÐ¾Ð±Ñ…Ð¾Ð´Ð¸Ð¼ÑƒÑŽ Ð´Ð»Ñ?
ÑƒÐ¿Ñ€Ð°Ð²Ð»ÐµÐ½Ð¸Ñ? Ð¸Ñ?Ñ…Ð¾Ð´Ñ?Ñ‰ÐµÐ¹ Ð¿Ð¾Ñ‡Ñ‚Ñ‹ Ñ? Ð¿Ð¾Ð¼Ð¾Ñ‰ÑŒÑŽ
PHP. Ð­Ñ‚Ð¾ Ð²ÐºÐ»ÑŽÑ‡Ð°ÐµÑ‚ Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶ÐºÑƒ Ð´Ð»Ñ?
Ñ‚ÐµÐºÑ?Ñ‚Ð¾Ð²Ñ‹Ñ… Ð¸ HTML-Ð¿Ð¾Ñ‡Ñ‚Ñ‹, Ð½ÐµÑ?ÐºÐ¾Ð»ÑŒÐºÐ¾
Ð¿Ð¾Ð»ÑƒÑ‡Ð°Ñ‚ÐµÐ»ÐµÐ¹ Ð¿Ð¾Ñ‡Ñ‚Ñ‹, ÑˆÐ°Ð±Ð»Ð¾Ð½Ñ‹ Ð¸ Ð²Ð»Ð¾Ð¶ÐµÐ½Ð½Ñ‹Ðµ
Ñ„Ð°Ð¹Ð»Ñ‹.

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
