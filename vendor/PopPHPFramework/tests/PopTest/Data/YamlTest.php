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
    Pop\Data\Yaml;

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

