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
        $this->assertInstanceOf('Pop\Form\Element', new Element('text', 'email'));
    }

    public function testConstructorException()
    {
        $this->setExpectedException('Pop\Form\Exception');
        $e = new Element('bogus', 'email');
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
        $e = new Element('text', 'email');
        $e->addValidator(new Email());
        $e->value = 'testtest.com';
        $this->assertFalse($e->validate());
        $this->assertContains('class="error"', $e->render(true));
    }

    public function testRender()
    {
        $e = new Element('text', 'email');
        $element = $e->render(true);

        ob_start();
        $e->output();
        $output = ob_get_clean();

        $this->assertContains('<input', $element);
        $this->assertContains('<input', $output);
    }

}

