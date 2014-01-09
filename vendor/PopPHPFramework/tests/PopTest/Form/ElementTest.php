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
use Pop\Form\Element;
use Pop\Validator\Email;

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

    public function testSetAndGetName()
    {
        $e = new Element('text', 'email');
        $e->setName('new_email');
        $this->assertEquals('new_email', $e->getName());
    }

    public function testGetType()
    {
        $e = new Element('text', 'email');
        $this->assertEquals('text', $e->getType());
    }

    public function testSetAndGetValidators()
    {
        $e = new Element('text', 'email');
        $e->setValidators(array(new Email()));
        $vals = $e->getValidators();
        $this->assertEquals(1, count($vals));
    }

    public function testClearErrors()
    {
        $e = new Element('text', 'email');
        $e->clearErrors();
        $errors = $e->getErrors();
        $this->assertEquals(0, count($errors));
    }

    public function testElementType()
    {
        $e = new Element('text', 'email');
        $this->assertFalse($e->isCaptcha());
        $this->assertFalse($e->isCheckbox());
        $this->assertFalse($e->isCsrf());
        $this->assertFalse($e->isRadio());
        $this->assertFalse($e->isSelect());
        $this->assertFalse($e->isTextarea());
    }

    public function testSetAndGetValue()
    {
        $e = new Element('text', 'email');
        $e->setValue('email@email.com');
        $this->assertEquals('email@email.com', $e->getValue());
    }

    public function testSetAndGetLabel()
    {
        $e = new Element('text', 'email');
        $e->setLabel('Email:');
        $e->setLabel(array('Email:' => array('class' => 'label-class')));
        $this->assertEquals('Email:', $e->getLabel());
    }

    public function testSetAndGetLabelAttributes()
    {
        $e = new Element('text', 'email');
        $e->setLabel('Email:');
        $e->setLabelAttributes(array('class' => 'label-class'));
        $attribs = $e->getLabelAttributes();
        $this->assertEquals('label-class', $attribs['class']);
    }

    public function testErrorPre()
    {
        $e = new Element('text', 'email');
        $e->setErrorPre(true);
    }

    public function testErrorPost()
    {
        $e = new Element('text', 'email');
        $e->setErrorPost(true);
    }

    public function testErrorDisplay()
    {
        $e = new Element('text', 'email');
        $e->setErrorDisplay('h3', array('class' => 'error-class'), true);
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
        $e->setValue('test@test.com');
        $this->assertTrue($e->validate());
        $e = new Element('text', 'email');
        $e->addValidator(new Email());
        $e->setValue('testtest.com');
        $this->assertFalse($e->validate());
        $this->assertContains('class="error"', $e->render(true));
        $this->assertGreaterThan(0, count($e->getErrors()));
        $this->assertTrue($e->hasErrors());
    }

    public function testRender()
    {
        $e = new Element('text', 'email');
        $element = $e->render(true);
        $e->setErrorPre(true);
        $element = $e->render(true);

        ob_start();
        $e->output();
        $output = ob_get_clean();


        $this->assertContains('<input', $element);
        $this->assertContains('<input', $output);
    }

}

