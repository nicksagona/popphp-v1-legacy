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
    Pop\Code\PropertyGenerator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class PropertyTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\\Code\\PropertyGenerator', PropertyGenerator::factory('testProp', 'string', 123));
    }

    public function testStatic()
    {
        $p = PropertyGenerator::factory('testProp', 'string', 123);
        $p->setStatic(true);
        $this->assertTrue($p->isStatic());
    }

    public function testType()
    {
        $p = PropertyGenerator::factory('testProp', 'string', 123);
        $p->setType('string');
        $this->assertEquals('string', $p->getType());
    }

    public function testVisibility()
    {
        $p = PropertyGenerator::factory('testProp', 'string', 123);
        $p->setVisibility('protected');
        $this->assertEquals('protected', $p->getVisibility());
    }

    public function testGetNameAndValue()
    {
        $p = PropertyGenerator::factory('testProp', 'string', 123);
        $this->assertEquals('testProp', $p->getName());
        $this->assertEquals(123, $p->getValue());
    }

}

