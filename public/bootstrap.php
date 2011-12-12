<?php

require_once __DIR__ . '/../vendor/PopPHPFramework/src/Pop/Loader/Autoloader.php';
use Pop\Loader\Autoloader;

// Instantiate the autoloader object.
$autoloader = Autoloader::factory();
$autoloader->splAutoloadRegister();

/*
 * Add any optional custom loader features here, such as,
 * registering a vendor library namespace prefix with the autoloader,
 * or, loading a class map file
 *
 */
// $autoloader->register('YourApp', __DIR__ . '/../module/YourApp/src');
// $autoloader->loadClassMap('/../module/YourApp/classmap.php');
