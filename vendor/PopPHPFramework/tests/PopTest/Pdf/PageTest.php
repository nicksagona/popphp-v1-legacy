<?php
/**
 * Pop PHP Framework Unit Tests
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
 */

namespace PopTest\Pdf;

use Pop\Loader\Autoloader,
    Pop\Pdf\Page;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class PageTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Pdf\Page', new Page(null, null, null, null, 5));
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

