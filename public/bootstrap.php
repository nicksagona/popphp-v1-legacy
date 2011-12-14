<?php
/**
 * Pop PHP Framework Bootstrap File
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.TXT.
 * It is also available through the world-wide-web at this URL:
 * http://www.popphp.org/LICENSE.TXT
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@popphp.org so we can send you a copy immediately.
 *
 * IMPORTANT!
 *
 * If you move this 'bootstrap.php' file, make sure you adjust
 * the path to the Autoloader class file in the 'require'
 * statement below accordingly.
 *
 */

// Require the Autoloader class file
require_once __DIR__ . '/../vendor/PopPHPFramework/src/Pop/Loader/Autoloader.php';

// Instantiate the autoloader object
$autoloader = Pop\Loader\Autoloader::factory();
$autoloader->splAutoloadRegister();

/*
 * Unless you move this 'bootstrap.php' file and need to alter the path to the
 * Autoloader class file in the 'require' statement above, then it is best NOT
 * to edit this file above this doc block.
 *
 * However, you can add any optional custom code or loader features below this
 * doc block, such as, loading a module, registering a third-party library or
 * loading a class map file. Some examples are commented out below.
 *
 */

// require_once $autoloader->loadModule('YourModule');
// $autoloader->register('YourLib', __DIR__ . '/../vendor/YourLib/src');
// $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

