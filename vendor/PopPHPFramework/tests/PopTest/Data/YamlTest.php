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
use Pop\Data\Type\Yaml;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class YamlTest extends \PHPUnit_Framework_TestCase
{

    public function testDecode()
    {
        $yaml = <<<YAML
%YAML 1.1
---
 username: "Test1"
 password: "123456"
 email: "test1@test.com"
-
 username: "Test2"
 password: "123456"
 email: "test2@test.com"
YAML;
        $y = Yaml::decode($yaml);
        $this->assertEquals(2, count($y));
        $this->assertEquals('Test1', $y['row_1']['username']);
    }

    public function testEncode()
    {
        $ary = array(
            array('Name' => 'Test1', 'Num' => 1),
            array('Name' => 'Test2', 'Num' => 2)
        );
        $y = Yaml::encode($ary);
        $this->assertContains('Name: "Test1"', $y);
    }

}

