<?php

require_once '../../bootstrap.php';

use Pop\Code\NamespaceGenerator;

try {
    // Create namespace object
    $ns = new NamespaceGenerator('Some\\Other');
    $ns->setUse('Some\\Other\\Thing')
       ->setUse('Some\\Other\\Blah', 'B')
       ->setUse('Some\\Other\\Another');

    // Output the namespace
    echo $ns . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
