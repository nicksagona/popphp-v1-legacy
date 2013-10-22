<?php

require_once '../../bootstrap.php';

use Pop\Crypt;

try {
    $md5 = new Crypt\Md5();
    $hash = $md5->create('12password34');

    echo $hash . '<br/ >';

    if ($md5->verify('12password34', $hash)) {
        echo 'Verified!<br />';
    } else {
        echo 'NOT Verified!<br />';
    }
} catch (\Exception $e) {
    echo $e->getMessage();
}

