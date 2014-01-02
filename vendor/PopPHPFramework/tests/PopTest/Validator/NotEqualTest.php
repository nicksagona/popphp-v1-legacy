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
use Pop\Validator\NotEqual;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class NotEqualTest extends \PHPUnit_Framework_TestCase
{

    public function testEvaluateTrue()
    {
        $v = new NotEqual(10);
        $this->assertTrue($v->evaluate(11));
        $this->assertFalse($v->evaluate(10));
    }

    public function testEvaluateFalse()
    {
        $v = new NotEqual(10, null, false);
        $this->assertFalse($v->evaluate(11));
        $this->assertTrue($v->evaluate(10));
    }

}

