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

namespace PopTest\Payment;

use Pop\Loader\Autoloader,
    Pop\Payment\Payment,
    Pop\Payment\Adapter\Authorize;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class PaymentTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $p->adapter()->set('123 Main St.', 'address');
        $p->adapter()->set(array('address' => '123 Main St.', 'city' => 'New Orleans'));
        $this->assertInstanceOf('Pop\\Payment\\Payment', $p);
        $this->assertInstanceOf('Pop\\Payment\\Adapter\\Authorize', $p->adapter());
    }

    public function testIsTest()
    {
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $this->assertTrue($p->isTest());
    }

    public function testIsValid()
    {
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $this->assertFalse($p->isValid());
    }

    public function testIsApproved()
    {
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $this->assertFalse($p->isApproved());
    }

    public function testIsDeclined()
    {
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $this->assertFalse($p->isDeclined());
    }

    public function testIsError()
    {
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $this->assertFalse($p->isError());
    }

    public function testGetResponse()
    {
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $this->assertNull($p->getResponse());
    }

    public function testGetResponseCodes()
    {
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $this->assertEquals(0, count($p->getResponseCodes()));
    }

    public function testGetCode()
    {
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $this->assertNull($p->getCode(0));
    }

    public function testGetResponseCode()
    {
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $this->assertNull($p->getResponseCode());
    }

    public function testGetMessage()
    {
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $this->assertNull($p->getMessage());
    }

    public function testShippingSameAsBilling()
    {
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $p->firstName = 'Test';
        $p->lastName = 'Smith';
        $p->company = 'Test Company';
        $p->address = '123 Main St.';
        $p->city = 'New Orleans';
        $p->state = 'LA';
        $p->zip = '70130';
        $p->country = 'US';

        $p->shippingSameAsBilling();

        $this->assertEquals('Test', $p->shipToFirstName);
        $this->assertEquals('Smith', $p->shipToLastName);
        $this->assertEquals('Test Company', $p->shipToCompany);
        $this->assertEquals('123 Main St.', $p->shipToAddress);
        $this->assertEquals('New Orleans', $p->shipToCity);
        $this->assertEquals('LA', $p->shipToState);
        $this->assertEquals('70130', $p->shipToZip);
        $this->assertEquals('US', $p->shipToCountry);
    }

    public function testMagicMethods()
    {
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $p->firstName = 'Test';
        $this->assertTrue(isset($p->firstName));
        unset($p->firstName);
        $this->assertNull($p->firstName);
    }

    public function testSendException()
    {
        $this->setExpectedException('Pop\\Payment\\Adapter\\Exception');
        $p = new Payment(new Authorize('API_LOGIN_ID', 'TRANS_KEY', Payment::TEST));
        $p->send();
    }

}

