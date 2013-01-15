<?php

require_once '../../bootstrap.php';

use Pop\Curl\Curl;

try {
    $options = array(
        CURLOPT_URL    => 'http://www.popphp.org/LICENSE.TXT',
        CURLOPT_HEADER => FALSE
    );

    header('Content-Type: text/plain; charset=utf-8');

    $curl = new Curl($options);
    $curl->execute();
    unset($curl);
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
