Pop PHP Framework
=================

Documentation : Mail
--------------------

Il componente Mail fornisce le funzionalità necessarie per gestire la posta in uscita tramite PHP. Questo include il supporto per la posta elettronica basati su testo e HTML-based, i destinatari di posta, i modelli ed i file allegati.

<pre>
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

$mail = new Mail($rcpts, 'Hello World!');
$mail->setHeaders(array(
    'From'        => array('name' => 'Bob', 'email' => 'bob123@gmail.com'),
    'Reply-To'    => array('name' => 'Bob', 'email' => 'bob123@gmail.com'),
    'X-Mailer'    => 'PHP/' . phpversion(),
    'X-Priority'  => '3',
));

$html = &lt;&lt;&lt;HTMLMSG
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;
        Test HTML Email
    &lt;/title&gt;
    &lt;meta http-equiv="Content-Type" content="text/html; charset=utf-8" /&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Hello [{name}]&lt;/h1&gt;
    &lt;p&gt;
        I'm just trying out this new Pop Mail Library component.
    &lt;/p&gt;
    &lt;p&gt;
        Thanks,&lt;br /&gt;
        Bob
    &lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;

HTMLMSG;

$mail->setText("Hello [{name}],\n\nI'm just trying out this new Pop Mail component.\n\nThanks,\nBob\n\n");
$mail->setHtml($html);
$mail->attachFile('../assets/files/test.pdf');
$mail->send();
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
