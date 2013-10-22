<?php

require_once '../../bootstrap.php';

use Pop\Crypt;

try {
    $bc = new Crypt\Bcrypt();
    $hash = $bc->create('12password34');

    echo $hash . '<br/ >';

    if ($bc->verify('12password34', $hash)) {
        echo 'Verified!<br />';
    } else {
        echo 'NOT Verified!<br />';
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}

