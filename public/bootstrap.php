<?php

require_once '../vendor/PopPHPFramework/src/Pop/Autoloader.php';

$autoloader = new Pop_Autoloader();

// Add a vendor library namespace to the autoloader (optional)
//$autoloader->register('SomeLibrary', __DIR__ . '/../vendor/SomeLibrary/src');

// Register the autoloader object with the SPL
$autoloader->splAutoloadRegister();
