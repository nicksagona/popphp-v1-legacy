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
    Pop\Code\NamespaceGenerator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class NamespaceTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\\Code\\NamespaceGenerator', NamespaceGenerator::factory('TestNamespace'));
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
        $n->setUse('Test\\Space\\One', 'One');
        $n->setUses(array(array('Test\\Space\\Two', 'Two'), 'Test\\Space\\Three'));
        $codeStr = (string)$n;
        $code = $n->render(true);
        ob_start();
        $n->render();
        $output = ob_get_clean();
        $this->assertContains('use Test\\Space\\One as One', $code);
        $this->assertContains('Test\\Space\\Two as Two', $code);
        $this->assertContains('use Test\\Space\\One', $codeStr);
        $this->assertContains('Test\\Space\\Two', $codeStr);
        $this->assertContains('use Test\\Space\\One', $output);
        $this->assertContains('Test\\Space\\Two', $output);
    }

}

