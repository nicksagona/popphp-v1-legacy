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
use Pop\Validator\Excluded;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ExcludedTest extends \PHPUnit_Framework_TestCase
{

    public function testEvaluateTrue()
    {
        $v = new Excluded(3);
        $this->assertFalse($v->evaluate(array(1, 2, 3)));
        $v = new Excluded(4);
        $this->assertTrue($v->evaluate(array(1, 2, 3)));
    }

    public function testEvaluateFalse()
    {
        $v = new Excluded(3, null, false);
        $this->assertTrue($v->evaluate(array(1, 2, 3)));
        $v = new Excluded(4, null, false);
        $this->assertFalse($v->evaluate(array(1, 2, 3)));
    }

    public function testEvaluateStringTrue()
    {
        $v = new Excluded(3);
        $this->assertFalse($v->evaluate(123));
        $v = new Excluded(4);
        $this->assertTrue($v->evaluate(123));
    }

    public function testEvaluateStringFalse()
    {
        $v = new Excluded(3, null, false);
        $this->assertTrue($v->evaluate(123));
        $v = new Excluded(4, null, false);
        $this->assertFalse($v->evaluate(123));
        $v = new Excluded(array(4, 5), null, false);
        $this->assertFalse($v->evaluate(123));
    }

}

