<?php
/**
 * Pop PHP Framework Unit Tests (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Test
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace PopTest\Loader;

use Pop\Loader\Autoloader;
use Pop\Loader\Classmap;
use Pop\Filter\String;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class LoaderTest extends \PHPUnit_Framework_TestCase
{

    public function testAutoloader()
    {
        $a = new Autoloader();
        $a->splAutoloadRegister();
        $this->assertInstanceOf('Pop\Loader\Autoloader', $a);
        $this->assertInstanceOf('Pop\Loader\Autoloader', Autoloader::factory());
    }

    public function testFallback()
    {
        $a = new Autoloader();
        $a->splAutoloadRegister(false, true);
        $this->assertInstanceOf('Pop\Loader\Autoloader', $a);
    }

    public function testClassmap()
    {
        $classmap = __DIR__ . '/../tmp/classmap.php';

        if (file_exists($classmap)) {
            unlink($classmap);
        }

        Classmap::generate(__DIR__ . '/../../../src', $classmap);
        $this->fileExists($classmap);

        $a = new Autoloader();
        $a->loadClassMap($classmap);
        $this->assertInstanceOf('Pop\Config', new \Pop\Config(array()));

        unlink($classmap);
    }

    public function testClassmapException()
    {
        $this->setExpectedException('Pop\Loader\Exception');
        $a = new Autoloader();
        $a->loadClassMap('bad.php');
    }

    public function testRegister()
    {
        $a = new Autoloader(false);
        $a->register('Pop', __DIR__ . '/../../../src');
        $this->assertInstanceOf('Pop\Loader\Autoloader', $a);

    }

}

