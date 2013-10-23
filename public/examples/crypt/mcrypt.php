<?php

require_once '../../bootstrap.php';

use Pop\Crypt;

try {
    $mc = new Crypt\Mcrypt();

    $hash = $mc->create('12password34');

    echo 'Hash: ' . $hash . '<br/ >';

    echo 'Salt: ' . $mc->getSalt() . '<br />';
    echo 'Decrypted: ' . $mc->decrypt($hash) . '<br />';

    if ($mc->verify('12password34', $hash)) {
        echo 'Verified!<br />';
    } else {
        echo 'NOT Verified!<br />';
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}

