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
namespace PopTest\Data;

use Pop\Loader\Autoloader;
use Pop\Data\Type\Xml;

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

    public function testDecodePreserve()
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
        $x = Xml::decode($xml, true);
        $this->assertEquals(2, count($x['row']));
        $this->assertEquals('Test1', $x['row'][0]['username']);
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

