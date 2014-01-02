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
use Pop\Validator\Alpha;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class AlphaTest extends \PHPUnit_Framework_TestCase
{

    public function testSetAndGetCondition()
    {
        $v = new Alpha();
        $v->setCondition(true);
        $this->assertTrue($v->getCondition());
    }

    public function testSetAndGetInput()
    {
        $v = new Alpha();
        $v->setInput('123');
        $this->assertEquals('123', $v->getInput());
    }

    public function testSetAndGetValue()
    {
        $v = new Alpha();
        $v->setValue('123');
        $this->assertEquals('123', $v->getValue());
    }

    public function testEvaluateTrue()
    {
        $v = new Alpha();
        $this->assertTrue($v->evaluate('abcdef'));
        $this->assertFalse($v->evaluate('123456'));
    }

    public function testEvaluateFalse()
    {
        $v = new Alpha(null, null, false);
        $this->assertFalse($v->evaluate('abcdef'));
        $this->assertTrue($v->evaluate('123456'));
    }

}

