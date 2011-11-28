<?php

require_once '../vendor/PopPHPFramework/src/Pop/Loader/Autoloader.php';
use Pop\Loader\Autoloader;

// Instantiate the autoloader object,
// and/or (optionally) register a vendor library namespace prefix with the autoloader
// and/or (optionally) load a class map file
Autoloader::factory()
                     ->register('SomeLibrary', __DIR__ . '/../vendor/SomeLibrary/src')
                     //->loadClassMap('/../vendor/PopPHPFramework/classmap.php')
                     ->splAutoloadRegister();
