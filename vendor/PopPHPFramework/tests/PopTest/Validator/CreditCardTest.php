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
use Pop\Validator\CreditCard;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class CreditCardTest extends \PHPUnit_Framework_TestCase
{

    public function testEvaluateTrue()
    {
        $v = new CreditCard();
        $this->assertTrue($v->evaluate(4111111111111111));
        $this->assertTrue($v->evaluate('4111 1111 1111 1111'));
        $this->assertTrue($v->evaluate('4111-1111-1111-1111'));
        $this->assertFalse($v->evaluate(123456789));
    }

    public function testEvaluateFalse()
    {
        $v = new CreditCard(null, null, false);
        $this->assertFalse($v->evaluate(4111111111111111));
        $this->assertTrue($v->evaluate(123456789));
    }

}

