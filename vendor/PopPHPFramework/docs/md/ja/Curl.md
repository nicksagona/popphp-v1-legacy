Pop PHP Framework
=================

Documentation : Curl
--------------------

Home

Curlã?®ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?å?˜ã?«PHPã?®cURLæ‹¡å¼µãƒ¢ã‚¸ãƒ¥ãƒ¼ãƒ«ã?¸ã?®ã‚ªãƒ–ã‚¸ã‚§ã‚¯ãƒˆæŒ‡å?‘APIã?®ãƒ©ãƒƒãƒ‘ãƒ¼ã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚

    use Pop\Curl\Curl;

    $options = array(
        CURLOPT_URL            => 'http://pop.localhost/examples/curl/curl-process.php',
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => array('name' => 'Bubba', 'email' => 'bubba@hotmail.com'),
        CURLOPT_HEADER         => false,
        CURLOPT_RETURNTRANSFER => true
    );

    header('Content-Type: text/html; charset=utf-8');
    $curl = new Curl($options);
    echo $curl->execute();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
