<?php

require_once '../../bootstrap.php';

use Pop\Crypt;

try {
    $crypt = new Crypt\Crypt();
    $hash = $crypt->create('12password34');

    echo $hash . '<br/ >';

    if ($crypt->verify('12password34', $hash)) {
        echo 'Verified!<br />';
    } else {
        echo 'NOT Verified!<br />';
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}

