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
namespace PopTest\Dom;

use Pop\Loader\Autoloader;
use Pop\Dom\Dom;
use Pop\Dom\Child;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class DomTest extends \PHPUnit_Framework_TestCase
{

    public function testDomConstructor()
    {
        $this->assertInstanceOf('Pop\Dom\Dom', new Dom(Dom::XHTML11));
    }

    public function testAddChildren()
    {
        $d = new Dom(Dom::XHTML11, 'utf-8', new Child('p', 'This is another paragraph'));
        $d->addChild(new Child('p', 'This is a paragraph'));
        $this->assertEquals(2, count($d->getChildren()));
        $this->assertEquals('p', $d->getChild(0)->getNodeName());
    }

    public function testSetAndGetIndent()
    {
        $d = new Dom(Dom::XHTML11);
        $d->setIndent('    ');
        $this->assertEquals('    ', $d->getIndent());
    }

    public function testSetAndGetDoctype()
    {
        $d = new Dom(Dom::XHTML11);
        $d->setDoctype(Dom::ATOM);
        $this->assertContains('<?xml version="1.0"', $d->getDoctype());
        $d->setDoctype(Dom::RSS);
        $this->assertContains('<?xml version="1.0"', $d->getDoctype());
        $d->setDoctype(Dom::XML);
        $this->assertContains('<?xml version="1.0"', $d->getDoctype());
    }

    public function testSetAndGetCharset()
    {
        $d = new Dom(Dom::XHTML11);
        $d->setCharset('utf-8');
        $this->assertEquals('utf-8', $d->getCharset());
    }

    public function testSetAndGetContentType()
    {
        $d = new Dom(Dom::XHTML11);
        $d->setContentType('text/html');
        $this->assertEquals('text/html', $d->getContentType());
    }

    public function testAddChildException()
    {
        $d = new Dom(Dom::XHTML11);
        $this->setExpectedException('Pop\Dom\Exception');
        $d->addChild('badchild');
    }

    public function testAddAndRemoveChild()
    {
        $d = new Dom(Dom::XHTML11);
        $d->addChild(array('nodeName' => 'p', 'nodeValue' => 'This is a paragraph'));
        $this->assertEquals(1, count($d->getChildren()));
        $this->assertEquals('p', $d->getChild(0)->getNodeName());
        $this->assertTrue($d->hasChildren());
        $d->removeChild(0);
        $this->assertFalse($d->hasChildren());
    }

    public function testAddAndRemoveChildren()
    {
        $d = new Dom(Dom::XHTML11);
        $d->addChild(array('nodeName' => 'p', 'nodeValue' => 'This is a paragraph'));
        $this->assertEquals(1, count($d->getChildren()));
        $this->assertEquals('p', $d->getChild(0)->getNodeName());
        $this->assertTrue($d->hasChildren());
        $d->removeChildren();
        $this->assertFalse($d->hasChildren());
    }

    public function testRender()
    {
        $d = new Dom(Dom::XHTML11, 'utf-8', new Child('p', 'This is another paragraph'));
        $d->addChild(new Child('p', 'This is a paragraph'));
        $code = $d->render(true);
        ob_start();
        $d->render();
        $output = ob_get_clean();
        $this->assertContains('<p>', $code);
        $this->assertContains('<p>', $output);
    }

}

