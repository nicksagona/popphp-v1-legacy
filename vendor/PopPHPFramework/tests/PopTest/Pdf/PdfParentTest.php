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
use Pop\Pdf\Object\ParentObject;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class PdfParentTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Pdf\Object\ParentObject', new ParentObject());
    }

    public function testToString()
    {
        $p = new ParentObject("<<2 0 obj\n<</Type/Pages/Count 2/Kids [3 0 R 4 0 R]>>\nendobj\n>>");
        $this->assertContains('/Type/Pages/Count 2', (string)$p);
    }

}

