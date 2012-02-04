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

namespace Pop;

use Pop\Loader\Autoloader,
    Pop\Mvc\Controller,
    Pop\Mvc\Model,
    Pop\Mvc\Router,
    Pop\Mvc\View;

// Require the library's autoloader.
require_once __DIR__ . '/../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class MvcTest extends \PHPUnit_Framework_TestCase
{

    public function testControllerConstructor()
    {
        $c = new Controller();
        $class = 'Pop\\Mvc\\Controller';
        $this->assertTrue($c instanceof $class);
    }

    public function testModelConstructor()
    {
        $m = new Model();
        $class = 'Pop\\Mvc\\Model';
        $this->assertTrue($m instanceof $class);
    }

    public function testRouterConstructor()
    {
        $r = new Router(array('Pop\\Mvc\\Controller' => new Controller()));
        $class = 'Pop\\Mvc\\Router';
        $this->assertTrue($r instanceof $class);
    }

    public function testViewConstructor()
    {
        $v = new View();
        $class = 'Pop\\Mvc\\View';
        $this->assertTrue($v instanceof $class);
    }

}

?>