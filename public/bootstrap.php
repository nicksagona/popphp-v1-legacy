<?php

require_once __DIR__ . '/../vendor/PopPHPFramework/src/Pop/Loader/Autoloader.php';
use Pop\Loader\Autoloader;

// Instantiate the autoloader object,
// and/or (optionally) register a vendor library namespace prefix with the autoloader
// and/or (optionally) load a class map file
Autoloader::factory()
                     //->register('HelloWorld', __DIR__ . '/../module/HelloWorld/src')
                     //->loadClassMap('/../vendor/PopPHPFramework/classmap.php')
                     ->splAutoloadRegister();
