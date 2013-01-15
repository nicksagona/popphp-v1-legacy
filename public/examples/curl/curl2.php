<?php

require_once '../../bootstrap.php';

use Pop\Curl\Curl;

try {
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

    echo $output;
    unset($curl);
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
