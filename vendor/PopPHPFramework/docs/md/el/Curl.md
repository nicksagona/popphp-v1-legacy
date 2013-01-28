Pop PHP Framework
=================

Documentation : Curl
--------------------

Home

Î— Curl ÏƒÏ…ÏƒÏ„Î±Ï„Î¹ÎºÏŒ Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Î±Ï€Î»Î¬ Î­Î½Î±
object-oriented Ï€ÎµÏ?Î¹Ï„Ï?Î»Î¹Î³Î¼Î± API Î³Î¹Î± Ï„Î·Î½
ÎµÏ€Î­ÎºÏ„Î±ÏƒÎ· cURL Ï„Î·Ï‚ PHP.

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
