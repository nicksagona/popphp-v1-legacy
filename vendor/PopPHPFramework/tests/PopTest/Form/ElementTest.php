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

namespace PopTest\Form;

use Pop\Loader\Autoloader,
    Pop\Form\Element,
    Pop\Validator\Validator\Email;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ElementTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $e = new Element('text', 'email');
        $class = 'Pop\\Form\\Element';
        $this->assertTrue($e instanceof $class);
    }

    public function testLabel()
    {
        $e = new Element('text', 'email');
        $e->setLabel('Email:');
        $this->assertEquals('Email:', $e->label);
    }

    public function testRequired()
    {
        $e = new Element('text', 'email');
        $e->setRequired(true);
        $this->assertFalse($e->validate());
    }

    public function testValidate()
    {
        $e = new Element('text', 'email');
        $e->addValidator(new Email());
        $e->value = 'test@test.com';
        $this->assertTrue($e->validate());
    }

    public function testRender()
    {
        $e = new Element('text', 'email');
        $element = $e->render(true);
        $this->assertTrue((strpos($element, '<input') !== false));
    }

}

?>