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

namespace PopTest\Mail;

use Pop\Loader\Autoloader,
    Pop\Mail\Queue;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class QueueTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Mail\Queue', new Queue('some@email.com', 'Some One'));
        $this->assertInstanceOf('Pop\Mail\Queue', new Queue(array('email' => 'someone@email.com', 'name' => 'Some One')));
    }

    public function testAdd()
    {
        $q = new Queue();
        $q->add('some@email.com', 'Some One');
        $this->assertEquals(1, count($q));
    }

    public function testToString()
    {
        $q = new Queue('some@email.com', 'Some One');
        $q->add('someoneelse@email.com', 'Someone Else');
        $this->assertEquals('Some One <some@email.com>, Someone Else <someoneelse@email.com>', (string)$q);
    }

}

