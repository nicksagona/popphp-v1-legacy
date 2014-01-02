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
use Pop\Dom\Child;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ChildTest extends \PHPUnit_Framework_TestCase
{

    public function testChildConstructor()
    {
        $this->assertInstanceOf('Pop\Dom\Child', new Child('p', 'This is a paragraph'));
    }

    public function testChild()
    {
        $c = new Child('p', 'This is a paragraph', new Child('p', 'This is another paragraph'));
        $c->setAttributes('class', 'some-class');
        $this->assertEquals('p', $c->getNodeName());
        $this->assertEquals('This is a paragraph', $c->getNodeValue());
        $this->assertEquals('some-class', $c->getAttribute('class'));
    }

    public function testChildFactoryAndRender()
    {
        $children = array(
            'nodeName'      => 'div',
            'nodeValue'     => 'This is a div element',
            'attributes'    => array('id' => 'contentDiv'),
            'childrenFirst' => false,
            'childNodes'    => array(
                array(
                     'nodeName'      => 'p',
                     'nodeValue'     => 'This is a paragraph1',
                     'attributes'    => array('style' => 'font-size: 0.9em;'),
                     'childrenFirst' => false,
                     'childNodes'    => array(
                         array(
                             'nodeName'   => 'strong',
                             'nodeValue'  => 'This is bold!',
                             'attributes' => array('style' => 'font-size: 1.2em;')
                         )
                     )
                ),
                array(
                    'nodeName'   => 'p',
                    'nodeValue'  => 'This is another paragraph!',
                    'attributes' => array('style' => 'font-size: 0.9em;')
                )
            )
        );
        $c = Child::factory($children);
        $this->assertEquals('div', $c->getNodeName());
        $this->assertEquals(2, count($c->getChildren()));
        $this->assertEquals(1, count($c->getAttributes()));
        $code = $c->render(true);
        $string = (string)$c;
        ob_start();
        $c->render();
        $output = ob_get_clean();
        $this->assertContains('<div id="contentDiv">', $code);
        $this->assertContains('<div id="contentDiv">', $output);
        $this->assertContains('<div id="contentDiv">', $string);
    }

    public function testSetAndGetNodeName()
    {
        $c = new Child('p', 'This is a paragraph');
        $c->setNodeName('span');
        $this->assertEquals('span', $c->getNodeName());
    }

}

