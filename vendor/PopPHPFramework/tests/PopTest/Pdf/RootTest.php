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
namespace PopTest\Pdf;

use Pop\Loader\Autoloader;
use Pop\Pdf\Object\Root;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class RootTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Pdf\Object\Root', new Root());
    }

    public function testToString()
    {
        $r = new Root("<<1 0 obj\n<</Pages 2 0 R/Type/Catalog>>\nendobj\n>>");
        $this->assertContains('%PDF-1.7', (string)$r);
    }

}

