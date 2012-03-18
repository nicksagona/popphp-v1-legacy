Pop PHP Framework
=================

Documentation : Curl
--------------------

The Curl component simply provides an object-oriented API wrapper to PHP's cURL extension.

<pre>
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

$output = "<html>\n<body>\n<h1>cURL POST Test</h1>\n";
$output .= $curl->execute();
$output .= "\n</body>\n</html>\n";

unset($curl);
echo $output . PHP_EOL . PHP_EOL;
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
