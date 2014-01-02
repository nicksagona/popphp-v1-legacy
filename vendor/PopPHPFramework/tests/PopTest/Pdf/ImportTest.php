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
use Pop\Pdf\Import;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ImportTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Pdf\Import', new Import(__DIR__ . '/../tmp/test.pdf'));
    }

    public function testShiftObjects()
    {
        $i = new Import(__DIR__ . '/../tmp/test.pdf');
        $i->shiftObjects(5);
        $this->assertInstanceOf('Pop\Pdf\Import', $i);
        $this->assertTrue(is_array($i->returnObjects(2)));
    }

}

