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
use Pop\Code\Generator\FunctionGenerator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

function someFunction($arg1, $arg2) {
    echo $arg1 . ' ' . $arg2;
}

class FunctionTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\Code\Generator\FunctionGenerator', FunctionGenerator::factory('newFunction'));
    }

    public function testClosure()
    {
        $f = FunctionGenerator::factory('newFunction');
        $f->setClosure(true);
        $this->assertTrue($f->isClosure());
    }

    public function testDesc()
    {
        $f = FunctionGenerator::factory('newFunction');
        $f->setDesc('This is a test function');
        $f->setDesc('This is REALLY a test function');
        $this->assertEquals('This is REALLY a test function', $f->getDesc());
    }

    public function testIndent()
    {
        $f = FunctionGenerator::factory('newFunction');
        $f->setIndent('    ');
        $this->assertEquals('    ', $f->getIndent());
    }

    public function testName()
    {
        $f = FunctionGenerator::factory('newFunction');
        $f->setName('newNameFunction');
        $this->assertEquals('newNameFunction', $f->getName());
    }

    public function testDocblock()
    {
        $f = FunctionGenerator::factory('newFunction');
        $f->setDocblock(new DocblockGenerator('This is a test desc.'));
        $this->assertEquals('This is a test desc.', $f->getDocblock()->getDesc());
    }

    public function testBody()
    {
        $f = FunctionGenerator::factory('newFunction');
        $f->setBody('echo $arg;');
        $f->appendToBody('echo $arg;');
        $this->assertEquals('    echo $arg;' . PHP_EOL . '    echo $arg;' . PHP_EOL, $f->getBody());
    }

    public function testArguments()
    {
        $f = FunctionGenerator::factory('newFunction');
        $f->addArgument('testVar', 123, 'int');
        $f->addParameter('oneMoreTestVar', 789, 'int');
        $f->addArguments(array(
            array('name' => 'anotherTestVar', 'value' => 456, 'type' => 'int')
        ));
        $f->addParameters(array(
            array('name' => 'yetAnotherTestVar', 'value' => 987, 'type' => 'int')
        ));
        $this->assertTrue(is_array($f->getArguments()));
        $this->assertTrue(is_array($f->getParameters()));
        $arg = $f->getArgument('testVar');
        $par = $f->getParameter('oneMoreTestVar');
        $this->assertEquals(123, $arg['value']);
        $this->assertEquals(789, $par['value']);
        $params = $f->getParameterNames();
        $args = $f->getArgumentNames();
        $this->assertEquals('testVar', $params[0]);
        $this->assertEquals('testVar', $args[0]);


    }

    public function testRender()
    {
        $f = FunctionGenerator::factory('newFunction');
        $f->setBody('some body code', true);
        $f->appendToBody('some more body code');
        $f->appendToBody('even more body code', false);
        $f->addArgument('testVar', 123, 'int');
        $f->addParameter('oneMoreTestVar', 789, 'int');

        $codeStr = (string)$f;
        $code = $f->render(true);

        ob_start();
        $f->render();
        $output = ob_get_clean();
        $this->assertContains('function newFunction($testVar = 123, $oneMoreTestVar = 789)', $output);
        $this->assertContains('function newFunction($testVar = 123, $oneMoreTestVar = 789)', $code);
        $this->assertContains('function newFunction($testVar = 123, $oneMoreTestVar = 789)', $codeStr);
    }

    public function testRenderClosure()
    {
        $f = FunctionGenerator::factory('newFunction');
        $f->setClosure(true);
        $f->setBody('some body code', true);
        $f->appendToBody('some more body code');
        $f->appendToBody('even more body code', false);
        $f->addArgument('testVar', 123, 'int');
        $f->addParameter('oneMoreTestVar', 789, 'int');

        $codeStr = (string)$f;
        $code = $f->render(true);

        ob_start();
        $f->render();
        $output = ob_get_clean();
        $this->assertContains('$newFunction = function($testVar = 123, $oneMoreTestVar = 789)', $output);
        $this->assertContains('$newFunction = function($testVar = 123, $oneMoreTestVar = 789)', $code);
        $this->assertContains('$newFunction = function($testVar = 123, $oneMoreTestVar = 789)', $codeStr);

        $this->assertContains('};', $output);
        $this->assertContains('};', $code);
        $this->assertContains('};', $codeStr);
    }

    public function testParseFunction()
    {
        $func = function($var) { return $var; };
        $f = FunctionGenerator::factory('newFunction', $func);
        $this->assertEquals(1, count($f->getArguments()));

    }

}

