<?php

require_once '../../bootstrap.php';

use Pop\Event\Manager;

try {
    $manager = new Manager();
    $manager->attach('pre', function() { return 'Hello, World'; }, 2);
    $manager->attach('pre', function($name) { return 'Hello, ' . $name; }, 2);
    $manager->attach('pre', function($result) { echo $result . '<br />' . PHP_EOL; }, 1);
    $manager->trigger('pre', array('name' => 'World'));
} catch (\Exception $e) {
    echo $e->getMessage();
}

