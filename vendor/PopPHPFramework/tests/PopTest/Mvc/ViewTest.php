<?php
/**
 * Pop PHP Framework Unit Tests (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Test
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace PopTest\Mvc;

use Pop\Loader\Autoloader;
use Pop\Mvc\Model;
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
        $this->assertInstanceOf('Pop\Mvc\View', View::factory(__DIR__ . '/ModelTest.php', new Model()));
        $this->assertInstanceOf('Pop\Mvc\View', View::factory(__DIR__ . '/ModelTest.php', array()));
    }

    public function testSetAndGetModel()
    {
        $v = new View('some template');
        $v->setModel(new Model(123, 'data'));
        $this->assertEquals(123, $v->getModel()->data);
    }

    public function testGetTemplateFile()
    {
        $v = View::factory(__DIR__ . '/ModelTest.php', new Model());
        $this->assertEquals(__DIR__ . '/ModelTest.php', $v->getTemplateFile());
    }

    public function testGetTemplateString()
    {
        $v = View::factory('some template', new Model());
        $this->assertEquals('some template', $v->getTemplateString());
    }

    public function testSetTemplateFile()
    {
        $v = View::factory(null, new Model());
        $v->setTemplateFile(__DIR__ . '/ModelTest.php');
        $this->assertEquals(__DIR__ . '/ModelTest.php', $v->getTemplateFile());
        $v->setTemplateFile();
        $this->assertNull($v->getTemplateFile());
    }

    public function testSetTemplateFileException1()
    {
        $this->setExpectedException('Pop\Mvc\Exception');
        $v = View::factory(null, new Model());
        $v->setTemplateFile(__DIR__ . '/ModelTest.bad');
    }

    public function testSetTemplateFileException2()
    {
        $this->setExpectedException('Pop\Mvc\Exception');
        $v = View::factory(null, new Model());
        $v->setTemplateFile(__DIR__ . '/ModelTestBad.php');
    }

    public function testSetTemplateString()
    {
        $v = View::factory(null, new Model());
        $v->setTemplateString('some template');
        $this->assertEquals('some template', $v->getTemplateString());
    }

    public function testRenderException()
    {
        $this->setExpectedException('Pop\Mvc\Exception');
        $v = View::factory(null, new Model());
        $v->render();
    }

    public function testRender()
    {
        $v = View::factory('some template with a [{var}]', new Model('variable', 'var'));
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
        $data = new Model(array('list' => array('Thing #1', 'Thing #2')));
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

