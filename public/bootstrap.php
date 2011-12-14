<?php

require_once __DIR__ . '/../vendor/PopPHPFramework/src/Pop/Loader/Autoloader.php';

use Pop\Loader\Autoloader;

// Instantiate the autoloader object.
$autoloader = Autoloader::factory();
$autoloader->splAutoloadRegister();

/*
 * Add any optional custom loader features here, such as, loading a module,
 * registering a third-party library or loading a class map file.
 */
// require_once $autoloader->loadModule('YourModule');
// $autoloader->register('YourLib', __DIR__ . '/../vendor/YourLib/src');
// $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

