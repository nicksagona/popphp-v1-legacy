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

namespace PopTest\Mvc;

use Pop\Loader\Autoloader,
    Pop\Config,
    Pop\Http\Request,
    Pop\Http\Response,
    Pop\Mvc\Controller,
    Pop\Project\Project;

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

