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
namespace PopTest\Mail;

use Pop\Loader\Autoloader;
use Pop\Mail\Queue;

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

