Pop PHP Framework
=================

Documentation : Curl
--------------------

Home

Curl ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¿Ñ€Ð¾Ñ?Ñ‚Ð¾ Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚
Ð¾Ð±ÑŠÐµÐºÑ‚Ð½Ð¾-Ð¾Ñ€Ð¸ÐµÐ½Ñ‚Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ñ‹Ð¹ API Ð¾Ð±ÐµÑ€Ñ‚ÐºÐ¸,
Ñ‡Ñ‚Ð¾Ð±Ñ‹ Ð·Ð°Ð²Ð¸Ñ‚ÑŒ Ñ€Ð°Ñ?ÑˆÐ¸Ñ€ÐµÐ½Ð¸ÐµÐ¼ PHP.

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
