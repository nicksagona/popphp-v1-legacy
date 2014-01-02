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
namespace PopTest\Code;

use Pop\Loader\Autoloader;
use Pop\Code\Generator\DocblockGenerator;
use Pop\Code\Generator\InterfaceGenerator;
use Pop\Code\Generator\MethodGenerator;
use Pop\Code\Generator\NamespaceGenerator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class InterfaceTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\Code\Generator\InterfaceGenerator', InterfaceGenerator::factory('TestInterface'));
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
        $i->setNamespace(new NamespaceGenerator('Test\Space'));
        $this->assertEquals('Test\Space', $i->getNamespace()->getNamespace());
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
        $i->setNamespace(new NamespaceGenerator('Test\Space'))
          ->setParent('TestParent')
          ->setDocblock(new DocblockGenerator('This is a test desc.'))
          ->addMethod(new MethodGenerator('testMethod'));

        $code = (string)$i;
        $code = $i->render(true);


        ob_start();
        $i->render();
        $output = ob_get_clean();
        $this->assertContains('interface TestInterface', $output);
        $this->assertContains('interface TestInterface', $code);
    }

}

