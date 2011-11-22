<?php
/**
 * Pop PHP Framework
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
 * @category   Pop
 * @package    Pop_Dom
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

require_once dirname(__FILE__) . '/../../library/Pop/Autoloader.php';
Pop_Autoloader::bootstrap();

class Pop_DomTest extends PHPUnit_Framework_TestCase
{

    public function testDomConstructor()
    {
        $d = new Pop_Dom('XHTML11', 'utf-8');
        $class = 'Pop_Dom';
        $this->assertTrue($d instanceof $class);
        $this->assertEquals('XHTML11', $d->getType());
        $this->assertEquals('utf-8', $d->getCharset());
    }

    public function testDomChildConstructor()
    {
        $c = new Pop_Dom_Child('div', 'This is a div.');
        $class = 'Pop_Dom_Child';
        $this->assertTrue($c instanceof $class);
        $this->assertEquals('div', $c->getNodeName());
        $this->assertEquals('This is a div.', $c->getNodeValue());
    }

    public function testDomAddChildren()
    {
        $c = new Pop_Dom_Child('div');
        $d = new Pop_Dom('XHTML11', 'utf-8');
        $d->addChildren($c);
        $this->assertEquals(1, count($d->getChildren()));
    }

    public function testDomChildAddChildren()
    {
        $c1 = new Pop_Dom_Child('div');
        $c2 = new Pop_Dom_Child('h1', 'This is a header.');
        $c3 = new Pop_Dom_Child('p', 'This is a paragraph.');
        $c1->addChildren(array($c2, $c3));
        $this->assertEquals(2, count($c1->getChildren()));
    }

    public function testDomRender()
    {
        $c = new Pop_Dom_Child('div', 'Hello World!');
        $d = new Pop_Dom();
        $d->addChildren($c);
        $this->assertEquals("<div>Hello World!</div>\n", $d->render(true));
    }

}

?>