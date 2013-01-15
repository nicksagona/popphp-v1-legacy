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
    Pop\Data\Type\Json;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class JsonTest extends \PHPUnit_Framework_TestCase
{

    public function testDecode()
    {
        $json = '{"name" : "test1", "num" : "2" }';
        $j = Json::decode($json);
        $this->assertEquals('test1', $j->name);
        $this->assertEquals(2, $j->num);
    }

    public function testEncode()
    {
        $ary = array(
            array('Name' => 'Test1', 'Num' => 1),
            array('Name' => 'Test2', 'Num' => 2)
        );
        $j = Json::encode($ary);
        $this->assertEquals('[{"Name":"Test1","Num":1},{"Name":"Test2","Num":2}]', $j);
    }

}

