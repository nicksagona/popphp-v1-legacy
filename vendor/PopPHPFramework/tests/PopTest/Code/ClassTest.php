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
use Pop\Code\Generator\ClassGenerator;
use Pop\Code\Generator\DocblockGenerator;
use Pop\Code\Generator\MethodGenerator;
use Pop\Code\Generator\NamespaceGenerator;
use Pop\Code\Generator\PropertyGenerator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ClassTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\Code\Generator\ClassGenerator', ClassGenerator::factory('TestClass'));
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

    public function testSetAndGetIndent()
    {
        $c = ClassGenerator::factory('TestClass');
        $c->setIndent('    ');
        $this->assertEquals('    ', $c->getIndent());
    }

    public function testSetAndGetName()
    {
        $c = ClassGenerator::factory('TestClass');
        $c->setName('MyTestClass');
        $this->assertEquals('MyTestClass', $c->getName());
    }

    public function testSetAndGetNamespace()
    {
        $c = ClassGenerator::factory('TestClass');
        $c->setNamespace(new NamespaceGenerator('Test\Space'));
        $this->assertEquals('Test\Space', $c->getNamespace()->getNamespace());
    }

    public function testSetAndGetDocblock()
    {
        $c = ClassGenerator::factory('TestClass');
        $c->setDocblock(new DocblockGenerator('This is a test desc.'));
        $this->assertEquals('This is a test desc.', $c->getDocblock()->getDesc());
    }

    public function testAddGetAndRemoveProperty()
    {
        $c = ClassGenerator::factory('TestClass');
        $c->addProperty(new PropertyGenerator('testProp', 'string', 'This is a test string'));
        $this->assertEquals('testProp', $c->getProperty('testProp')->getName());
        $this->assertEquals(1, count($c->getProperties()));
        $c->removeProperty('testProp');
        $this->assertNull($c->getProperty('testProp'));
    }

    public function testAddGetAndRemoveMethod()
    {
        $c = ClassGenerator::factory('TestClass');
        $c->addMethod(new MethodGenerator('testMethod'));
        $this->assertEquals('testMethod', $c->getMethod('testMethod')->getName());
        $this->assertEquals(1, count($c->getMethods()));
        $c->removeMethod('testMethod');
        $this->assertNull($c->getMethod('testMethod'));
    }

    public function testRender()
    {
        $c = ClassGenerator::factory('TestClass');
        $c->setAbstract(true)
          ->setParent('TestParent')
          ->setInterface('TestInterface')
          ->addProperty(new PropertyGenerator('testProp', 'string', 'This is a test string'))
          ->addMethod(new MethodGenerator('testMethod'));
        $code = $c->render(true);

        ob_start();
        $c->render();
        $output = ob_get_clean();
        $this->assertContains('class TestClass extends TestParent implements TestInterface', $output);

        $this->assertContains('abstract', $code);
        $this->assertContains('TestParent', $code);
        $this->assertContains('TestInterface', $code);
        $code = (string)$c;
        $this->assertContains('abstract', $code);
        $this->assertContains('TestParent', $code);
        $this->assertContains('TestInterface', $code);
    }

}

