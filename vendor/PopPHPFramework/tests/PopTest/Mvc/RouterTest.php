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
    Pop\Mvc\Controller,
    Pop\Mvc\Router,
    Pop\Project\Project;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class RouterTest extends \PHPUnit_Framework_TestCase
{

    public function testRouterConstructor()
    {
        $this->assertInstanceOf('Pop\\Mvc\\Router', new Router(array('Pop\\Mvc\\Controller' => new Controller())));
        $this->assertInstanceOf('Pop\\Mvc\\Router', Router::factory(array('Pop\\Mvc\\Controller' => new Controller())));
    }

    public function testAddAndGetControllers()
    {
        $r = new Router(array('Pop\\Mvc\\Controller' => new Controller()));
        $r->addControllers(array('Some\\Other\\Controller' => new Controller()));
        $this->assertInstanceOf('Pop\\Mvc\\Controller', $r->getController('Some\\Other\\Controller'));
    }

    public function testAction()
    {
        $r = new Router(array('Pop\\Mvc\\Controller' => new Controller()));
        $r->route(new Project(new Config(array())));
        $this->assertNull($r->getAction());
    }

    public function testRoute()
    {
        $r = new Router(array('Pop\\Mvc\\Controller' => new Controller()));
        $r->route(new Project(new Config(array())));
        $this->assertNull($r->controller());
    }

}

