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
        $this->assertInstanceOf('Pop\Mvc\Router', new Router(array('/' => 'Pop\Mvc\Controller')));
        $this->assertInstanceOf('Pop\Mvc\Router', Router::factory(array('/' => 'Pop\Mvc\Controller')));
    }

    public function testAddAndGetControllers()
    {
        $r = new Router(array('/' => 'Some\New\Controller'));
        $r->addControllers(array('/other' => 'Some\New\OtherController'));
        $this->assertEquals(2, count($r->getControllers()));
        $r->addControllers(array('/' => array('/test' => 'Some\New\TestController')));
        $this->assertEquals(2, count($r->getControllers()));
    }

    public function testGetRequest()
    {
        $r = new Router(array('/' => 'Pop\Mvc\Controller'), new Request());
        $this->assertInstanceOf('Pop\Http\Request', $r->request());
    }

    public function testGetControllerClass()
    {
        $r = new Router(array('/' => 'Pop\Mvc\Controller'), new Request());
        $this->assertNull( $r->getControllerClass());
    }

    public function testAction()
    {
        $r = new Router(array('/' => 'Pop\Mvc\Controller'));
        $r->route(new Project(new Config(array())));
        $this->assertEquals('index', $r->getAction());
    }

    public function testRoute()
    {
        $r = new Router(array('/' => 'Pop\Mvc\Controller'));
        $r->route(new Project(new Config(array())));
        $this->assertInstanceOf('Pop\Mvc\Controller', $r->controller());
        $this->assertInstanceOf('Pop\Project\Project', $r->project());
    }

}

