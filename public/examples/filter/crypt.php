<?php

require_once '../../bootstrap.php';

use Pop\Filter\Crypt;

try {
    $key = 'This is my key.';

    $encrypted = Crypt::encrypt('Hello World!', $key);
    echo $encrypted . '<br />' . PHP_EOL;

    $decrypted = Crypt::decrypt($encrypted, $key);
    echo $decrypted . '<br />' . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>