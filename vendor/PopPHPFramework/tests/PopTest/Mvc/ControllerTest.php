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
use Pop\Config;
use Pop\Http\Request;
use Pop\Http\Response;
use Pop\Mvc\Controller;
use Pop\Project\Project;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ControllerTest extends \PHPUnit_Framework_TestCase
{

    public function testControllerConstructor()
    {
        $this->assertInstanceOf('Pop\Mvc\Controller', new Controller(null, null, new Project(new Config(array())), '/admin'));
    }

    public function testSetAndGetRequest()
    {
        $c = new Controller();
        $c->setRequest(new Request('/test-uri', '/admin'));
        $this->assertEquals('/test-uri', $c->getRequest()->getRequestUri());
        $this->assertEquals('/admin', $c->getRequest()->getBasePath());
    }

    public function testSetAndGetResponse()
    {
        $c = new Controller();
        $c->setResponse(new Response(200, array('Content-Type' => 'text/html')));
        $this->assertEquals(200, $c->getResponse()->getCode());
    }

    public function testSetAndGetProject()
    {
        $c = new Controller();
        $c->setProject(new Project(new Config(array('data' => 123))));
        $this->assertEquals(123, $c->getProject()->config()->data);
    }

    public function testSetAndGetViewPath()
    {
        $c = new Controller();
        $c->setViewPath('/admin');
        $this->assertEquals('/admin', $c->getViewPath());
        $this->assertNull($c->getView());
    }

    public function testSetAndGetErrorAction()
    {
        $c = new Controller();
        $c->setErrorAction('myerror');
        $this->assertEquals('myerror', $c->getErrorAction());
    }

    public function testDispatchException()
    {
        $this->setExpectedException('Pop\Mvc\Exception');
        $c = new Controller();
        $c->dispatch();
    }

    public function testSendException()
    {
        $this->setExpectedException('Pop\Mvc\Exception');
        $c = new Controller();
        $c->send();
    }

}

