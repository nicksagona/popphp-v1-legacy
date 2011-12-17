<?php

require_once '../../bootstrap.php';

use Pop\Code\NamespaceGenerator;

try {
    // Create namespace object
    $ns = new NamespaceGenerator('Some\\Namespace');
    $ns->setUse('Some\\Namespace\\Thing')
       ->setUse('Some\\Namespace\\Blah', 'B')
       ->setUse('Some\\Namespace\\Another');

    // Output the namespace
    echo $ns . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>