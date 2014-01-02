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
use Pop\Pdf\Object\Page;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class PageTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Pdf\Object\Page', new Page(null, null, null, null, 5));
    }

    public function testToString()
    {
        $p = new Page(null, 'Letter', null, null, 5);
        $p = new Page(null, null, 612, 792, 5);
        $this->assertContains('MediaBox[0 0 612 792]', (string)$p);

        $p = new Page("5 0 obj\n<</Type/Page/Parent 2 0 R/MediaBox[0 0 612 792]/Contents[ 0 R]/Resources<</ProcSet[/PDF/Text/ImageB/ImageC/ImageI]>>>>\nendobj\n>>");
        $this->assertContains('MediaBox[0 0 612 792]', (string)$p);
    }

}

