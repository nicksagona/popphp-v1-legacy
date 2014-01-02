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
use Pop\Form\Element\Checkbox;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class CheckboxTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Form\Element\Checkbox', new Checkbox('colors', array('Red', 'Blue', 'Green')));
    }

    public function testMarked()
    {
        $c = new Checkbox('colors', array('Red', 'Blue', 'Green'), array('Red', 'Green'));
        $this->assertEquals(array('Red', 'Green'), $c->getMarked());
    }

    public function testSetMarked()
    {
        $c = new Checkbox('colors', array('Red' => 'Red', 'Blue' => 'Blue', 'Green' => 'Green'));
        $c->setMarked( array('Red', 'Green'));
        $this->assertEquals(array('Red', 'Green'), $c->getMarked());
    }

    public function testSetMarkedSingle()
    {
        $c = new Checkbox('colors', array('Red' => 'Red', 'Blue' => 'Blue', 'Green' => 'Green'), 'Green');
        $this->assertEquals('Green', $c->getMarked());
    }

}

