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
use Pop\Code\Generator\PropertyGenerator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class PropertyTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\Code\Generator\PropertyGenerator', PropertyGenerator::factory('testProp', 'string', 123));
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

    public function testSetAndGetName()
    {
        $p = PropertyGenerator::factory('testProp', 'string', 123);
        $p->setName('newTestProp');
        $this->assertEquals('newTestProp', $p->getName());
    }

    public function testGetNameAndValue()
    {
        $p = PropertyGenerator::factory('testProp', 'string', 123);
        $p->setValue(456);
        $this->assertEquals(456, $p->getValue());
    }

    public function testSetAndGetDesc()
    {
        $p = PropertyGenerator::factory('testProp', 'string', 123);
        $p->setDesc('This is the desc.');
        $p->setDesc('This is the new desc.');
        $this->assertEquals('This is the new desc.', $p->getDesc());
        $this->assertInstanceOf('Pop\Code\Generator\DocblockGenerator', $p->getDocblock());
    }

    public function testSetAndGetDocblock()
    {
        $p = PropertyGenerator::factory('testProp', 'string', 123);
        $p->setDocblock(new DocblockGenerator('This is the desc.'));
        $this->assertEquals('This is the desc.', $p->getDocblock()->getDesc());
    }

    public function testSetAndGetIndent()
    {
        $p = PropertyGenerator::factory('testProp', 'string', 123);
        $p->setIndent('    ');
        $this->assertEquals('    ', $p->getIndent());
    }

    public function testRender()
    {
        $p = PropertyGenerator::factory('testProp', 'array', array(0, 1, 2));
        $this->assertContains('array', $p->render(true));
        $p = PropertyGenerator::factory('testProp', 'array', array('prop1' => 1, 'prop2' => 2));
        $this->assertContains('array', $p->render(true));
        $p = PropertyGenerator::factory('testProp', 'int', 0);
        $this->assertContains('int', $p->render(true));
        $p = PropertyGenerator::factory('testProp', 'boolean', true);
        $this->assertContains('boolean', $p->render(true));
        $p = PropertyGenerator::factory('testProp', 'string', 0, 'const');
        $this->assertContains('const', $p->render(true));
        $p = PropertyGenerator::factory('testProp', 'string', 123);
        $p = PropertyGenerator::factory('testProp', 'array');
        $p->setStatic(true);
        $this->assertTrue($p->isStatic());

        $codeStr = (string)$p;
        $code = $p->render(true);

        ob_start();
        $p->render();
        $output = ob_get_clean();
        $this->assertContains('static', $code);
        $this->assertContains('static', $codeStr);
        $this->assertContains('static', $output);
    }

}

