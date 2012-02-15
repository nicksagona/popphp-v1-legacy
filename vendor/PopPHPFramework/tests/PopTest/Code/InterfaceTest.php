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
    Pop\Code\DocblockGenerator,
    Pop\Code\InterfaceGenerator,
    Pop\Code\MethodGenerator,
    Pop\Code\NamespaceGenerator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class InterfaceTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\\Code\\InterfaceGenerator', InterfaceGenerator::factory('TestInterface'));
    }

    public function testGetName()
    {
        $i = InterfaceGenerator::factory('TestInterface');
        $this->assertEquals('TestInterface', $i->getName());
    }

    public function testParent()
    {
        $i = InterfaceGenerator::factory('TestInterface');
        $i->setParent('TestParent');
        $this->assertEquals('TestParent', $i->getParent());
    }

    public function testSetAndGetIndent()
    {
        $i = InterfaceGenerator::factory('TestInterface');
        $i->setIndent('    ');
        $this->assertEquals('    ', $i->getIndent());
    }

    public function testSetAndGetName()
    {
        $i = InterfaceGenerator::factory('TestInterface');
        $i->setName('NewTestInterface');
        $this->assertEquals('NewTestInterface', $i->getName());
    }

    public function testSetAndGetNamespace()
    {
        $i = InterfaceGenerator::factory('TestInterface');
        $i->setNamespace(new NamespaceGenerator('Test\\Space'));
        $this->assertEquals('Test\\Space', $i->getNamespace()->getNamespace());
    }

    public function testSetAndGetDocblock()
    {
        $i = InterfaceGenerator::factory('TestInterface');
        $i->setDocblock(new DocblockGenerator('This is a test desc.'));
        $this->assertEquals('This is a test desc.', $i->getDocblock()->getDesc());
    }

    public function testAddGetAndRemoveMethod()
    {
        $i = InterfaceGenerator::factory('TestInterface');
        $i->addMethod(new MethodGenerator('testMethod'));
        $this->assertEquals('testMethod', $i->getMethod('testMethod')->getName());
        $i->removeMethod('testMethod');
        $this->assertNull($i->getMethod('testMethod'));
    }

    public function testRender()
    {
        $i = InterfaceGenerator::factory('TestInterface');
        $i->setNamespace(new NamespaceGenerator('Test\\Space'))
          ->setDocblock(new DocblockGenerator('This is a test desc.'))
          ->addMethod(new MethodGenerator('testMethod'));

        $code = $i->render(true);

        ob_start();
        $i->render();
        $output = ob_get_clean();
        $this->assertContains('interface TestInterface', $output);
        $this->assertContains('interface TestInterface', $code);
    }

}

