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
    Pop\Data\Type\Csv,
    Pop\Data\Data;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class CsvTest extends \PHPUnit_Framework_TestCase
{

    public function testDecode()
    {
        $csv = "Name,Num1,Num2,Num3\n\"Test's\",1,2,3\nTest,4,5,6";
        $c = Csv::decode($csv);
        $this->assertEquals(2, count($c));
        $this->assertEquals(4, $c['row_2']['Num1']);
    }

    public function testEncode()
    {
        $ary = array(
            array('Na"me' => '"Test\'s"', 'Num,Ber' => 1, 'Blah' => 3, 'date' => '2012-01-01'),
            array('Na"me' => 'Test2', 'Num,Ber' => "2,Yes", 'Blah' => 3, 'date' => 'bogusdate')
        );

        $c = Csv::encode($ary);
        $this->assertContains('Na""me,"Num,Ber"', $c);
        $this->assertContains('Test2,"2,Yes"', $c);

        $c = Csv::encode($ary, 'Blah');
        $this->assertContains('Na""me,"Num,Ber"', $c);
        $this->assertContains('Test2,"2,Yes"', $c);
    }

}

