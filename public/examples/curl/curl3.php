<?php

require_once '../../bootstrap.php';

use Pop\Curl\Curl;

try {
    $total = 0;

    $curl = new Curl('http://www.popphp.org/license');
    $curl->setOption(CURLOPT_WRITEFUNCTION, function($curl, $data) {
        global $total;
        $len = strlen($data);
        $total += $len;
        echo $len . ' (' . $total . ')<br />' . PHP_EOL;
        return $len;
    });

    $curl->execute();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
