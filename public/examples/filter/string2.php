<?php

require_once '../../bootstrap.php';

use Pop\Filter\String;

try {
    echo String::random(10, String::ALPHANUM, String::LOWER);
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>