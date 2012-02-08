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

namespace PopTest\Code;

use Pop\Loader\Autoloader,
    Pop\Code\ClassGenerator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ClassTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $c = ClassGenerator::factory('TestClass');
        $class = 'Pop\\Code\\ClassGenerator';
        $this->assertTrue($c instanceof $class);
    }

    public function testGetName()
    {
        $c = ClassGenerator::factory('TestClass');
        $this->assertEquals('TestClass', $c->getName());
    }

    public function testAbstract()
    {
        $c = ClassGenerator::factory('TestClass');
        $c->setAbstract(true);
        $this->assertTrue($c->isAbstract());
    }

    public function testParent()
    {
        $c = ClassGenerator::factory('TestClass');
        $c->setParent('TestParent');
        $this->assertEquals('TestParent', $c->getParent());
    }

    public function testInterface()
    {
        $c = ClassGenerator::factory('TestClass');
        $c->setInterface('TestInterface');
        $this->assertEquals('TestInterface', $c->getInterface());
    }

    public function testRender()
    {
        $c = ClassGenerator::factory('TestClass');
        $c->setAbstract(true)
          ->setParent('TestParent')
          ->setInterface('TestInterface');
        $code = $c->render(true);
        $this->assertTrue((strpos($code, 'abstract') !== false));
        $this->assertTrue((strpos($code, 'TestParent') !== false));
        $this->assertTrue((strpos($code, 'TestInterface') !== false));
    }

}

?>