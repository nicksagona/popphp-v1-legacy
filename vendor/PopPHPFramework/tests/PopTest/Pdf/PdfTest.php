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
use Pop\Color\Space\Rgb;
use Pop\Pdf\Pdf;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class PdfTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Pdf\Pdf', new Pdf('doc.pdf'));
        $this->assertInstanceOf('Pop\Pdf\Pdf', new Pdf(__DIR__ . '/../tmp/test.pdf'));
    }

    public function testAddCopyAndDeletePage()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter');
        $p->copyPage(1);
        $p->orderPages(array(2, 1));
        $p->setPage(1);
        $this->assertEquals(1, $p->curPage());
        $p->deletePage(2);
        $this->assertEquals(1, $p->numPages());
    }

    public function testSetPageException()
    {
        $this->setExpectedException('Pop\Pdf\Exception');
        $p = new Pdf('doc.pdf');
        $p->setPage(1);
    }

    public function testCopyPageException()
    {
        $this->setExpectedException('Pop\Pdf\Exception');
        $p = new Pdf('doc.pdf');
        $p->copyPage(1);
    }

    public function testDeletePageException()
    {
        $this->setExpectedException('Pop\Pdf\Exception');
        $p = new Pdf('doc.pdf');
        $p->deletePage(1);
    }

    public function testOrderPagesException1()
    {
        $this->setExpectedException('Pop\Pdf\Exception');
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter');
        $p->addPage('Letter');
        $p->orderPages(array(1, 2, 3));
    }

    public function testOrderPagesException2()
    {
        $this->setExpectedException('Pop\Pdf\Exception');
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter');
        $p->addPage('Letter');
        $p->orderPages(array(1, 3));
    }

    public function testOrderPagesException3()
    {
        $this->setExpectedException('Pop\Pdf\Exception');
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter');
        $p->orderPages(array(1, 2));
    }

    public function testSetAndGetCompression()
    {
        $p = new Pdf('doc.pdf');
        $p->setCompression(true);
        $this->assertTrue($p->getCompression());
    }

    public function testSetAttributes()
    {
        $p = new Pdf('doc.pdf');
        $p->setVersion(1.4)
          ->setTitle('Title')
          ->setAuthor('Author')
          ->setSubject('Subject')
          ->setCreateDate('10/10/10')
          ->setModDate('10/11/10')
          ->setBackgroundColor(new Rgb(255, 0, 0))
          ->setTextParams(10, 10);

        $this->assertInstanceOf('Pop\Pdf\Pdf', $p);
    }

    public function testTextParamsException1()
    {
        $this->setExpectedException('Pop\Pdf\Exception');
        $p = new Pdf('doc.pdf');
        $p->setTextParams(10, 10, 50, 50, 100);
    }

    public function testTextParamsException2()
    {
        $this->setExpectedException('Pop\Pdf\Exception');
        $p = new Pdf('doc.pdf');
        $p->setTextParams(10, 10, 50, 50, 45, 8);
    }

    public function testAddAndGetFonts()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter');
        $p->setPage(1);
        $p->addFont('Arial');
        $p->addFont('Courier');
        $this->assertEquals('Courier', $p->getLastFontName());
        $this->assertEquals(2, count($p->getFonts()));
        $this->assertTrue(in_array('Arial', $p->getFonts()));
    }

    public function testAddTextException()
    {
        $this->setExpectedException('Pop\Pdf\Exception');
        $p = new Pdf('doc.pdf');
        $p->addText(10, 10, 36, 'Hello World', 'BadFont');
    }

    public function testGetStringSize()
    {
        $p = new Pdf('doc.pdf');
        $ary = $p->getStringSize('Hello World', 'Arial', 36);
        $this->assertEquals(198, $ary['width']);
        $this->assertEquals(36, $ary['height']);
    }

    public function testGetStringSizeException()
    {
        $this->setExpectedException('Pop\Pdf\Exception');
        $p = new Pdf('doc.pdf');
        $ary = $p->getStringSize('Hello World', 'BadFont', 36);
    }

    public function testAddRectangle()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter');
        $p->drawRectangle(0, 0, 100);
        $this->assertInstanceOf('Pop\Pdf\Pdf', $p);
    }

    public function testAddSquare()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter');
        $p->drawSquare(0, 0, 100);
        $this->assertInstanceOf('Pop\Pdf\Pdf', $p);
    }

    public function testAddEllipse()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter');
        $p->drawEllipse(100, 100, 100);
        $this->assertInstanceOf('Pop\Pdf\Pdf', $p);
    }

    public function testAddCircle()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter');
        $p->drawCircle(100, 100, 100);
        $this->assertInstanceOf('Pop\Pdf\Pdf', $p);
    }

    public function testAddArc()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter');
        $p->drawArc(100, 100, 100, 180, 100);
        $this->assertInstanceOf('Pop\Pdf\Pdf', $p);
    }

    public function testOpenAndCloseLayer()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter')
          ->openLayer();
        $p->drawArc(100, 100, 100, 180, 100)
          ->closeLayer();
        $this->assertInstanceOf('Pop\Pdf\Pdf', $p);
    }

    public function testClippingShapes()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter')
          ->drawClippingRectangle(100, 100, 100)
          ->drawClippingSquare(100, 100, 100)
          ->drawClippingEllipse(100, 100, 100)
          ->drawClippingCircle(100, 100, 100);
        $this->assertInstanceOf('Pop\Pdf\Pdf', $p);
    }

    public function testAddUrl()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter')
          ->addUrl(10, 10, 300, 200, 'http://www.google.com/');
        $this->assertInstanceOf('Pop\Pdf\Pdf', $p);
    }

    public function testAddLink()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter')
          ->addUrl(10, 10, 300, 200, 50, 50, 50, 3);
        $this->assertInstanceOf('Pop\Pdf\Pdf', $p);
    }

    public function testAddImageAndScale1()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter')
          ->addImage(__DIR__ . '/../tmp/test.jpg', 320, 240, 0.5, true);
        $this->assertInstanceOf('Pop\Pdf\Pdf', $p);
    }

    public function testAddImageAndScale2()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter')
          ->addImage(__DIR__ . '/../tmp/test.png', 320, 240, 0.5, false);
        $this->assertInstanceOf('Pop\Pdf\Pdf', $p);
    }

    public function testAddImageAndSave()
    {
        $p = new Pdf('doc.pdf');
        $p->addPage('Letter')
          ->addImage(__DIR__ . '/../tmp/test.jpg', 320, 240)
          ->save(__DIR__ . '/../tmp/newtest.pdf');
        $this->assertInstanceOf('Pop\Pdf\Pdf', $p);
        $this->fileExists(__DIR__ . '/../tmp/newtest.pdf');
        unlink(__DIR__ . '/../tmp/newtest.pdf');
    }

}

