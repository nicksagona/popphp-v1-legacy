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
namespace PopTest\Form;

use Pop\Loader\Autoloader;
use Pop\Form\Element\Select;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class SelectTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Form\Element\Select', new Select('colors', array('Red', 'Blue', 'Green')));
    }

    public function testMarked()
    {
        $s = new Select('colors', array('Red', 'Blue', 'Green'), 'Green');
        $this->assertEquals('Green', $s->getMarked());
    }

    public function testSetMarked()
    {
        $s = new Select('colors', array('Red' => 'Red', 'Blue' => 'Blue', 'Green' => 'Green'), 'Green');
        $this->assertEquals('Green', $s->getMarked());
    }

    public function testMultiple()
    {
        $s = new Select('colors', array('Red' => 'Red', 'Blue' => 'Blue', 'Green' => 'Green'), array('Blue', 'Green'));
        $s->setAttributes('multiple', 'multiple');
        $this->assertEquals(2, count($s->getMarked()));
    }

    public function testOptGroup()
    {
        $s = new Select(
            'colors',
            array(
                'Red' => 'Red',
                'Blue' => 'Blue',
                'Green' => 'Green',
                'Other' => array(
                    'Black' => 'Black',
                    'White' => 'White'
                )
            ),
            array('Blue', 'Black')
        );
        $s->setAttributes('multiple', 'multiple');
        $this->assertContains('<optgroup label="', $s->render(true));
    }

    public function testYear()
    {
        $s = new Select('select_test', 'YEAR_1900_2000');
        $this->assertContains('<option value="1900">1900</option>', $s->render(true));
        $s = new Select('select_test', 'YEAR_2000_1900');
        $this->assertContains('<option value="1900">1900</option>', $s->render(true));
        $s = new Select('select_test', 'YEAR_1900');
        $this->assertContains('<option value="1900">1900</option>', $s->render(true));
        $s = new Select('select_test', 'YEAR_2100');
        $this->assertContains('<option value="2100">2100</option>', $s->render(true));
        $s = new Select('select_test', 'YEAR');
        $this->assertContains('<option value="', $s->render(true));
    }

    public function testMonthsShort()
    {
        $s = new Select('select_test', Select::MONTHS_SHORT);
        $this->assertContains('<option value="01">01</option>', $s->render(true));
    }

    public function testMonthsLong()
    {
        $s = new Select('select_test', Select::MONTHS_LONG);
        $this->assertContains('<option value="01">January</option>', $s->render(true));
    }

    public function testDaysOfMonths()
    {
        $s = new Select('select_test', Select::DAYS_OF_MONTH);
        $this->assertContains('<option value="31">31</option>', $s->render(true));
    }

    public function testDaysOfWeek()
    {
        $s = new Select('select_test', Select::DAYS_OF_WEEK);
        $this->assertContains('<option value="Sunday">Sunday</option>', $s->render(true));
    }

    public function testHours12()
    {
        $s = new Select('select_test', Select::HOURS_12);
        $this->assertContains('<option value="12">12</option>', $s->render(true));
    }

    public function testHours24()
    {
        $s = new Select('select_test', Select::HOURS_24);
        $this->assertContains('<option value="23">23</option>', $s->render(true));
    }

    public function testMinutes()
    {
        $s = new Select('select_test', Select::MINUTES);
        $this->assertContains('<option value="59">59</option>', $s->render(true));
    }

    public function testMinutes5()
    {
        $s = new Select('select_test', Select::MINUTES_5);
        $this->assertContains('<option value="05">05</option>', $s->render(true));
    }

    public function testMinutes10()
    {
        $s = new Select('select_test', Select::MINUTES_10);
        $this->assertContains('<option value="10">10</option>', $s->render(true));
    }

    public function testMinutes15()
    {
        $s = new Select('select_test', Select::MINUTES_15);
        $this->assertContains('<option value="15">15</option>', $s->render(true));
    }

    public function testStatesShort()
    {
        $s = new Select('select_test', Select::US_STATES_SHORT);
        $this->assertContains('<option value="LA">LA</option>', $s->render(true));
    }

    public function testStatesLong()
    {
        $s = new Select('select_test', Select::US_STATES_LONG);
        $this->assertContains('<option value="LA">Louisiana</option>', $s->render(true));
    }

    public function testXml()
    {
        $s = new Select('select_test', 'COUNTRIES');
        $this->assertContains('<option value="US">United States</option>', $s->render(true));
    }

    public function testXmlNotFound()
    {
        $s = new Select('select_test', 'BOGUS');
        $this->assertContains('<option value="0">BOGUS</option>', $s->render(true));
    }

}

