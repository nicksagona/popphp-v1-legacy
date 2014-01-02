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
namespace PopTest\Validator;

use Pop\Loader\Autoloader;
use Pop\Validator\IsSubnetOf;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class IsSubnetOfTest extends \PHPUnit_Framework_TestCase
{

    public function testEvaluateTrue()
    {
        $v = new IsSubnetOf('192.168.1');
        $this->assertTrue($v->evaluate('192.168.1.10'));
        $this->assertFalse($v->evaluate('10.0.0.79'));
    }

    public function testEvaluateFalse()
    {
        $v = new IsSubnetOf('192.168.1', null, false);
        $this->assertFalse($v->evaluate('192.168.1.10'));
        $this->assertTrue($v->evaluate('10.0.0.79'));
    }

    public function testEvaluateException()
    {
        $this->setExpectedException('Pop\Validator\Exception');
        $v = new IsSubnetOf('192.168.1', null, false);
        $v->evaluate('192168110');
    }
}

