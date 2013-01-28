Pop PHP Framework
=================

Documentation : Curl
--------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† Ø§Ù„Ø¶Ù?ÙŠØ±Ø© ÙŠÙˆÙ?Ø± Ø§Ù„Ù…Ø¬Ù…Ø¹ API Ù…Ø¬Ø±Ø¯ ÙˆØ¬ÙˆÙ‡
Ø§Ù„Ù…Ù†Ø­Ù‰ Ù„ØªÙ…Ø¯ÙŠØ¯ PHP Ù„Ø­Ù„ÙŠÙ‚Ø©.

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
