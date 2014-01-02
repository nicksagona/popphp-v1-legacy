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
namespace PopTest\Shipping;

use Pop\Loader\Autoloader;
use Pop\Shipping\Shipping;
use Pop\Shipping\Adapter\Fedex;
use Pop\Shipping\Adapter\Ups;
use Pop\Shipping\Adapter\Usps;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ShippingTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $s = new Shipping(new Fedex('KEY', 'PASSWORD', 'ACCT_NUM', 'METER_NUM'));
        $this->assertInstanceOf('Pop\Shipping\Shipping', $s);
        $this->assertInstanceOf('Pop\Shipping\Adapter\Fedex', $s->adapter());
        $s = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));
        $this->assertInstanceOf('Pop\Shipping\Shipping', $s);
        $this->assertInstanceOf('Pop\Shipping\Adapter\Ups', $s->adapter());
        $s = new Shipping(new Usps('USERNAME', 'PASSWORD'));
        $this->assertInstanceOf('Pop\Shipping\Shipping', $s);
        $this->assertInstanceOf('Pop\Shipping\Adapter\Usps', $s->adapter());
    }

    public function testIsSuccess()
    {
        $s = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));
        $this->assertFalse($s->isSuccess());
    }

    public function testIsError()
    {
        $s = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));
        $this->assertTrue($s->isError());
    }


    public function testGetResponse()
    {
        $s = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));
        $this->assertNull($s->getResponse());
    }

    public function testGetResponseCode()
    {
        $s = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));
        $this->assertNull($s->getResponseCode());
    }

    public function testGetResponseMessage()
    {
        $s = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));
        $this->assertNull($s->getResponseMessage());
    }

    public function testGetRates()
    {
        $s = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));
        $this->assertEquals(0, count($s->getRates()));
    }

    public function testSetShipTo()
    {
        $s = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));
        $s->shipTo(array('address' => '123 Main St.'));
        $this->assertInstanceOf('Pop\Shipping\Adapter\Ups', $s->adapter());
    }

    public function testSetShipFrom()
    {
        $s = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));
        $s->shipFrom(array('address' => '123 Main St.'));
        $this->assertInstanceOf('Pop\Shipping\Adapter\Ups', $s->adapter());
    }

    public function testSetDimensions()
    {
        $s = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));
        $s->setDimensions(array('length' => 12, 'width' => 6, 'height' => 3), 'IN');
        $this->assertInstanceOf('Pop\Shipping\Adapter\Ups', $s->adapter());
    }

    public function testSetWeight()
    {
        $s = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));
        $s->setWeight(5, 'LBS');
        $this->assertInstanceOf('Pop\Shipping\Adapter\Ups', $s->adapter());
    }

}

