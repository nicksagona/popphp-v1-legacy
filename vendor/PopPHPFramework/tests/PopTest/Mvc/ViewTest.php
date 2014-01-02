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
namespace PopTest\Mvc;

use Pop\Loader\Autoloader;
use Pop\Mvc\View;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ViewTest extends \PHPUnit_Framework_TestCase
{

    public function testViewConstructor()
    {
        $this->assertInstanceOf('Pop\Mvc\View', new View('some template'));
        $this->assertInstanceOf('Pop\Mvc\View', View::factory(__DIR__ . '/RouterTest.php', array()));
    }

    public function testSetAndGetModelData()
    {
        $v = new View('some template');
        $v->setData(array(123, 'something'));
        $v->set('new', 'thing');
        $d = $v->getData();
        $this->assertTrue(in_array(123, $d));
        $this->assertEquals('something', $v->get(1));
        $this->assertEquals('thing', $v->get('new'));
        $this->assertEquals('thing', $v->new);
        $v->new = 'somethingelse';
        $this->assertEquals('somethingelse', $v->new);
        $this->assertTrue(isset($v->new));
        $v->merge(array('newthing' => 456));
        $this->assertTrue(isset($v->newthing));
        $this->assertEquals(456, $v->newthing);
    }

    public function testGetTemplateFile()
    {
        $v = View::factory(__DIR__ . '/RouterTest.php', array());
        $this->assertEquals(__DIR__ . '/RouterTest.php', $v->getTemplateFile());
    }

    public function testGetTemplateString()
    {
        $v = View::factory('some template', array());
        $this->assertEquals('some template', $v->getTemplateString());
    }

    public function testSetTemplate()
    {
        $v = View::factory(null, array());
        $v->setTemplate(__DIR__ . '/RouterTest.php');
        $this->assertEquals(__DIR__ . '/RouterTest.php', $v->getTemplateFile());
        $this->assertEquals(__DIR__ . '/RouterTest.php', $v->getTemplate());
        $v->setTemplate('some template');
        $this->assertEquals('some template', $v->getTemplateString());
        $this->assertEquals('some template', $v->getTemplate());
    }

    public function testSetTemplateFile()
    {
        $v = View::factory(null, array());
        $v->setTemplateFile(__DIR__ . '/RouterTest.php');
        $this->assertEquals(__DIR__ . '/RouterTest.php', $v->getTemplateFile());
        $this->assertNull($v->getTemplateString());
    }

    public function testSetTemplateFileException1()
    {
        $this->setExpectedException('Pop\Mvc\Exception');
        $v = View::factory(null, array());
        $v->setTemplateFile(__DIR__ . '/RouterTest.bad');
    }

    public function testSetTemplateFileException2()
    {
        $this->setExpectedException('Pop\Mvc\Exception');
        $v = View::factory(null, array());
        $v->setTemplateFile(__DIR__ . '/RouterTestBad.php');
    }

    public function testSetTemplateString()
    {
        $v = View::factory(null, array());
        $v->setTemplateString('some template');
        $this->assertEquals('some template', $v->getTemplateString());
        $this->assertNull($v->getTemplateFile());
    }

    public function testRenderException()
    {
        $this->setExpectedException('Pop\Mvc\Exception');
        $v = View::factory(null, array());
        $v->render();
    }

    public function testRender()
    {
        $v = View::factory('some template with a [{var}]', array('var' => 'variable'));
        $view = $v->render(true);

        ob_start();
        $v->render();
        $output = ob_get_clean();

        $this->assertEquals('some template with a variable', $view);
        $this->assertEquals('some template with a variable', (string)$v);
        $this->assertEquals('some template with a variable', $output);
    }

    public function testRenderStringWithLoop()
    {
        $data = array('list' => array('Thing #1', 'Thing #2'));
        $template = <<<TMPL
    <ul>
[{list}]        <li>[{value}]</li>[{/list}]
    </ul>
TMPL;
        $v = View::factory($template, $data);
        $view = $v->render(true);
        $this->assertContains('<li>Thing #1</li>', $view);
        $this->assertContains('<li>Thing #2</li>', $view);
    }

}

