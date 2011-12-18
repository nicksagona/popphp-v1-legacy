<?php

require_once '../../bootstrap.php';

use Pop\Code\Reflection;

try {
    $reflect = new Reflection('Pop\\Auth\\Auth');
    //$reflect = new Reflection('Pop\\Auth\\Adapter\\AuthTable');


} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>