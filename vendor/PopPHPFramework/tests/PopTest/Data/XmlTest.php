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

namespace PopTest\Data;

use Pop\Loader\Autoloader,
    Pop\Data\Xml;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class XmlTest extends \PHPUnit_Framework_TestCase
{

    public function testDecode()
    {
        $xml = <<<XML
<users>
    <row>
        <username>Test1</username>
        <password>123456</password>
        <email>test1@test.com</email>
    </row>
    <row>
        <username>Test2</username>
        <password>123456</password>
        <email>test2@test.com</email>
    </row>
</users>
XML;
        $x = Xml::decode($xml);
        $this->assertEquals(2, count($x));
        $this->assertEquals('Test1', $x['row_1']['username']);
    }

    public function testEncode()
    {
        $ary = array(
            array('Name' => 'Test1', 'Num' => 1),
            array('Name' => 'Test2', 'Num' => 2)
        );
        $x = Xml::encode($ary);
        $this->assertContains('<Name>Test1</Name>', $x);

        $x = Xml::encode($ary, 'users', true);
        $this->assertContains('<table name="users">', $x);
    }

}

