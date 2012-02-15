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
    Pop\Mvc\Controller,
    Pop\Mvc\Model,
    Pop\Mvc\Router,
    Pop\Mvc\View;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class MvcTest extends \PHPUnit_Framework_TestCase
{

    public function testControllerConstructor()
    {
        $this->assertInstanceOf('Pop\\Mvc\\Controller', new Controller());
    }

    public function testModelConstructor()
    {
        $this->assertInstanceOf('Pop\\Mvc\\Model', new Model());
    }

    public function testRouterConstructor()
    {
        $this->assertInstanceOf('Pop\\Mvc\\Router', new Router(array('Pop\\Mvc\\Controller' => new Controller())));
    }

    public function testViewConstructor()
    {
        $this->assertInstanceOf('Pop\\Mvc\\View', new View());
    }

}

