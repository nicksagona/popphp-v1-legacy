<?php

require_once '../../bootstrap.php';

use Pop\Locale\Translate;

try {
    $translate = new Translate('fr');
    $translate->getToken('CLIENT_ID', 'CLIENT_SECRET');
    $translate->translate('Hello, how are you?');
    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>