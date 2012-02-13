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
    Pop\Code\MethodGenerator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class MethodTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $m = MethodGenerator::factory('testMethod');
        $class = 'Pop\\Code\\MethodGenerator';
        $this->assertTrue($m instanceof $class);
    }

    public function testStatic()
    {
        $m = MethodGenerator::factory('testMethod');
        $m->setStatic(true);
        $this->assertTrue($m->isStatic());
    }

    public function testAbstract()
    {
        $m = MethodGenerator::factory('testMethod');
        $m->setAbstract(true);
        $this->assertTrue($m->isAbstract());
    }

    public function testFinal()
    {
        $m = MethodGenerator::factory('testMethod');
        $m->setFinal(true);
        $this->assertTrue($m->isFinal());
    }

    public function testVisibility()
    {
        $m = MethodGenerator::factory('testMethod');
        $m->setVisibility('protected');
        $this->assertEquals('protected', $m->getVisibility());
    }

    public function testGetName()
    {
        $m = MethodGenerator::factory('testMethod');
        $this->assertEquals('testMethod', $m->getName());
    }

}

