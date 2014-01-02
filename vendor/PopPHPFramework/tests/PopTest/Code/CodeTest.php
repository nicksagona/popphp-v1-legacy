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
use Pop\Code\Generator;
use Pop\Code\Generator\DocblockGenerator;
use Pop\Code\Generator\NamespaceGenerator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class CodeTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $c = new Generator('TestClass.php', Generator::CREATE_CLASS);
        $c = new Generator('TestInterface.php', Generator::CREATE_INTERFACE);
        $c = new Generator(__FILE__);
        $c->setClose(true);
        $this->assertInstanceOf('Pop\Code\Generator', $c);
    }

    public function testSetAndGetIndent()
    {
        $c = new Generator('TestClass.php', Generator::CREATE_CLASS);
        $c->setIndent('    ');
        $this->assertEquals('    ', $c->getIndent());
    }

    public function testSetAndGetDocblock()
    {
        $c = new Generator('TestClass.php', Generator::CREATE_CLASS);
        $c->setDocblock(new DocblockGenerator('This is a test desc.'));
        $this->assertEquals('This is a test desc.', $c->getDocblock()->getDesc());
    }

    public function testSetAppendAndGetDocblock()
    {
        $c = new Generator('TestClass.php', Generator::CREATE_CLASS);
        $c->setBody('test body');
        $c->appendToBody('more code');
        $body = $c->getBody();
        $this->assertContains('test body', $body);
        $this->assertContains('more code', $body);
    }

    public function testRenderAndSave()
    {
        $c = new Generator(__DIR__ . '/../tmp/Test.php', Generator::CREATE_CLASS);
        $c->setNamespace(new NamespaceGenerator('Test\Space'));
        $c->setBody('test body')
          ->setClose(true);
        $c->appendToBody('more code');
        $body = $c->render(true);

        ob_start();
        $c->render();
        $output = ob_get_clean();
        $this->assertContains('namespace Test\Space', $output);

        $c->save();
        $this->assertContains('test body', $body);
        $this->assertContains('more code', $body);
        $this->fileExists(__DIR__ . '/../tmp/Test.php');
        if (file_exists(__DIR__ . '/../tmp/Test.php')) {
            unlink(__DIR__ . '/../tmp/Test.php');
        }
    }

}

