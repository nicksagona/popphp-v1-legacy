Pop PHP Framework
=================

Documentation : Mail
--------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† ÙŠÙˆÙ?Ø± ÙˆØ¸Ø§Ø¦Ù? Ø§Ù„Ø¨Ø±ÙŠØ¯ Ø§Ù„Ù„Ø§Ø²Ù…Ø©
Ù„Ø¥Ø¯Ø§Ø±Ø© Ø§Ù„Ø¨Ø±ÙŠØ¯ Ø§Ù„ØµØ§Ø¯Ø± Ø¹Ø¨Ø± PHP. Ù‡Ø°Ø§ ÙŠØªØ¶Ù…Ù†
Ø¯Ø¹Ù… Ù„Ù„Ø¨Ø±ÙŠØ¯ Ø§Ù„Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠ ÙŠØ³ØªÙ†Ø¯ Ø¥Ù„Ù‰ Ù†Øµ HTML
ÙˆØ§Ù„Ù‚Ø§Ø¦Ù… Ø¹Ù„Ù‰ ÙˆØ§Ù„Ù…Ø³ØªÙ?ÙŠØ¯ÙŠÙ† Ø¥Ù„ÙƒØªØ±ÙˆÙ†ÙŠ
Ù…ØªØ¹Ø¯Ø¯Ø©ØŒ ÙˆÙ‚ÙˆØ§Ù„Ø¨ Ù…Ø±Ù?Ù‚Ø§Øª Ø§Ù„Ù…Ù„Ù?Ø§Øª.

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
