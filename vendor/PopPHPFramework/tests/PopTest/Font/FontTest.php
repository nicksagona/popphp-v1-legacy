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
namespace PopTest\Font;

use Pop\Loader\Autoloader;
use Pop\Font\TrueType;
use Pop\Font\TrueType\OpenType;
use Pop\Font\Type1;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class FontTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Font\TrueType', new TrueType(__DIR__ . '/../tmp/times.ttf'));
    }

    public function testConstructorException()
    {
        $this->setExpectedException('Pop\Font\Exception');
        $font = new TrueType(__DIR__ . '/../tmp/nofont.ttf');
    }

    public function testTrueType()
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

    public function testOpenType()
    {
        $f = new OpenType(__DIR__ . '/../tmp/bos.otf');
        $this->assertEquals(1000, $f->unitsPerEm);
        $this->assertEquals(750, $f->ascent);
        $this->assertEquals(-250, $f->descent);
        $this->assertEquals(-206, $f->bBox->xMin);
        $this->assertEquals(-303, $f->bBox->yMin);
        $this->assertEquals(2383, $f->bBox->xMax);
        $this->assertEquals(1038, $f->bBox->yMax);
        $this->assertEquals('BlackoakStd', $f->info->fullName);
    }

    public function testType1Pfb()
    {
        $f = new Type1(__DIR__ . '/../tmp/cez.pfb');
        $this->assertEquals(1000, $f->unitsPerEm);
        $this->assertEquals(800, $f->ascent);
        $this->assertEquals(200, $f->descent);
        $this->assertEquals(-658, $f->bBox->xMin);
        $this->assertEquals(-683, $f->bBox->yMin);
        $this->assertEquals(1672, $f->bBox->xMax);
        $this->assertEquals(1127, $f->bBox->yMax);
        $this->assertEquals('Cezanne', $f->info->fullName);
    }

    public function testType1Afm()
    {
        $f = new Type1(__DIR__ . '/../tmp/tcc.afm');
        $this->assertEquals(1000, $f->unitsPerEm);
        $this->assertEquals(873, $f->ascent);
        $this->assertEquals(-210, $f->descent);
        $this->assertEquals(-157, $f->bBox->xMin);
        $this->assertEquals(-269, $f->bBox->yMin);
        $this->assertEquals(1039, $f->bBox->xMax);
        $this->assertEquals(913, $f->bBox->yMax);
    }

}

