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
use Pop\Data\Type\Csv;
use Pop\Data\Data;

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

