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
use Pop\Data\Type\Json;

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

