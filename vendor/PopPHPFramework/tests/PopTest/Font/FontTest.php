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

namespace PopTest\Font;

use Pop\Loader\Autoloader,
    Pop\Font\TrueType;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class FontTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\\Font\\TrueType', new TrueType(__DIR__ . '/../tmp/times.ttf'));
    }


    public function testFont()
    {
        $f = new TrueType(__DIR__ . '/../tmp/times.ttf');
        $this->assertEquals(250, $f->missingWidth);
        $this->assertEquals(399, $f->numberOfHMetrics);
        $this->assertEquals(0, $f->italicAngle);
        $this->assertEquals(1000, $f->unitsPerEm);
        $this->assertEquals(810, $f->ascent);
        $this->assertEquals(-189, $f->descent);
        $this->assertEquals(-168, $f->bBox->xMin);
        $this->assertEquals(-218, $f->bBox->yMin);
        $this->assertEquals(1000, $f->bBox->xMax);
        $this->assertEquals(934, $f->bBox->yMax);
        $this->assertEquals('Times-Bold', $f->info->fullName);
    }

}

