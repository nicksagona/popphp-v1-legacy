<?php

require_once '../../bootstrap.php';

use Pop\Crypt;

try {
    $sha = new Crypt\Sha();
    $hash = $sha->create('12password34');

    echo $hash . '<br/ >';

    if ($sha->verify('12password34', $hash)) {
        echo 'Verified!<br />';
    } else {
        echo 'NOT Verified!<br />';
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}

