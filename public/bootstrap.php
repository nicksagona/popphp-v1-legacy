<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Loader
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * IMPORTANT!
 *
 * Require the Autoloader class file and instantiate the autoloader object.
 * If you change the relationship between this file and the framework,
 * adjust the path accordingly.
 */
require_once __DIR__ . '/../vendor/PopPHPFramework/src/Pop/Loader/Autoloader.php';

$autoloader = new \Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

/**
 * Add any additional custom code or loader features below this doc block.
 * For example, you can register a third-party library or load a classmap file.
 * Some examples are:
 *
 *     $autoloader->register('YourLib', __DIR__ . '/../vendor/YourLib/src');
 *     $autoloader->loadClassMap('../vendor/YourLib/classmap.php');
 */

