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
use Pop\Code\Generator\NamespaceGenerator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class NamespaceTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\Code\Generator\NamespaceGenerator', NamespaceGenerator::factory('TestNamespace'));
    }

    public function testSetAndGetNamespace()
    {
        $n = NamespaceGenerator::factory('TestNamespace');
        $n->setNamespace('NewTestNamespace');
        $this->assertEquals('NewTestNamespace', $n->getNamespace());
    }

    public function testSetUsesAndRender()
    {
        $n = NamespaceGenerator::factory('TestNamespace');
        $n->setUse('Test\Space\One', 'One');
        $n->setUses(array(array('Test\Space\Two', 'Two'), 'Test\Space\Three'));
        $codeStr = (string)$n;
        $code = $n->render(true);
        ob_start();
        $n->render();
        $output = ob_get_clean();
        $this->assertContains('use Test\Space\One as One', $code);
        $this->assertContains('Test\Space\Two as Two', $code);
        $this->assertContains('use Test\Space\One', $codeStr);
        $this->assertContains('Test\Space\Two', $codeStr);
        $this->assertContains('use Test\Space\One', $output);
        $this->assertContains('Test\Space\Two', $output);
    }

}

