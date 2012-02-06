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
    Pop\Data\Data;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class DataTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $d = new Data(__DIR__ . '/../tmp/test.sql');
        $class = 'Pop\\Data\\Data';
        $this->assertTrue($d instanceof $class);
    }

    public function testData()
    {
        $d = new Data(__DIR__ . '/../tmp/test.sql');
        $ary = $d->parseFile();
        $keys = array('id', 'username', 'password', 'email', 'access');
        $this->assertEquals(9, count($ary));
        $this->assertEquals($keys, array_keys($ary['row_1']));
    }

}

?>