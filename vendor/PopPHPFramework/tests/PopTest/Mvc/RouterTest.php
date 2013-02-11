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
use Pop\Config;
use Pop\Http\Request;
use Pop\Mvc\Controller;
use Pop\Mvc\Router;
use Pop\Project\Project;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class RouterTest extends \PHPUnit_Framework_TestCase
{

    public function testRouterConstructor()
    {
        $this->assertInstanceOf('Pop\Mvc\Router', new Router(array('Pop\Mvc\Controller' => new Controller())));
        $this->assertInstanceOf('Pop\Mvc\Router', Router::factory(array('Pop\Mvc\Controller' => new Controller())));
    }

    public function testAddAndGetControllers()
    {
        $r = new Router(array('Pop\Mvc\Controller' => new Controller()));
        $r->addControllers(array('Some\Other\Controller' => new Controller()));
        $this->assertInstanceOf('Pop\Mvc\Controller', $r->getController('Some\Other\Controller'));
        $this->assertEquals(2, count($r->getControllers()));
    }

    public function testGetRequest()
    {
        $r = new Router(array('Pop\Mvc\Controller' => new Controller()), new Request());
        $this->assertInstanceOf('Pop\Http\Request', $r->request());
    }

    public function testAction()
    {
        $r = new Router(array('Pop\Mvc\Controller' => new Controller()));
        $r->route(new Project(new Config(array())));
        $this->assertNull($r->getAction());
    }

    public function testRoute()
    {
        $r = new Router(array('Pop\Mvc\Controller' => new Controller()));
        $r->route(new Project(new Config(array())));
        $this->assertNull($r->controller());
        $this->assertInstanceOf('Pop\Project\Project', $r->project());
    }

}

