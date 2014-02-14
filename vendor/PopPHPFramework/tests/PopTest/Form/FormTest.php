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
use Pop\Form\Form;
use Pop\Form\Element;
use Pop\Form\Element\Checkbox;
use Pop\Form\Element\Radio;
use Pop\Form\Element\Select;
use Pop\Form\Element\Textarea;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class FormTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Form\Form', new Form('/submit', 'post'));
        $this->assertInstanceOf('Pop\Form\Form', Form::factory('/submit', 'post'));
    }

    public function testConstructorSetFields()
    {
        $fields = array(
            'username' => array(
                'type'       => 'text',
                'value'      => 'Username here...',
                'label'      => 'Username:',
                'required'   => true,
                'attributes' => array('size' => 40)
            )
        );
        $f = new Form('/submit', 'post', $fields);
        $f->setErrorDisplay('h3', array('class' => 'error-class'), true);
        $this->assertEquals(1, count($f->getFields()));
    }

    public function testSetFields()
    {
        $fields = array(
            'username' => array(
                'type'       => 'text',
                'value'      => 'Username here...',
                'label'      => 'Username:',
                'required'   => true,
                'attributes' => array('size' => 40)
            ),
            'upload' => array(
                'type'       => 'file',
                'label'      => 'File:',
                'required'   => true,
                'attributes' => array('size' => 40)
            )
        );
        $f = new Form('/submit', 'post', $fields);
        $this->assertEquals(2, count($f->getFields()));
        $this->assertTrue($f->hasFile());
    }

    public function testGetAndSetField()
    {
        $fields = array(
            'username' => array(
                'type'       => 'text',
                'value'      => 'Username here...',
                'label'      => 'Username:',
                'required'   => true,
                'attributes' => array('size' => 40)
            ),
            'submit' => array(
                'type'       => 'submit',
                'value'      => 'SUBMIT'
            )
        );
        $f = new Form('/submit', 'post', $fields);
        $submit = $f->getField('submit');
        $this->assertEquals('SUBMIT', $submit['value']);
        $submit['value'] = 'NEW SUBMIT';

        $f->setField('submit', $submit);
        $submit = $f->getField('submit');
        $this->assertEquals('NEW SUBMIT', $submit['value']);
    }

    public function testSetArrayOfFields()
    {
        $fields = array(
            array(
                'username' => array(
                    'type'       => 'text',
                    'value'      => 'Username here...',
                    'label'      => 'Username:',
                    'required'   => true,
                    'attributes' => array('size' => 40)
                ),
                'upload' => array(
                    'type'       => 'file',
                    'label'      => 'File:',
                    'required'   => true,
                    'attributes' => array('size' => 40)
                )
            ),
            array(
                'email1' => array(
                    'type'       => 'text',
                    'label'      => 'Email 1:',
                    'required'   => true,
                    'attributes' => array('size' => 40)
                ),
                'email2' => array(
                    'type'       => 'text',
                    'label'      => 'Email 1:',
                    'required'   => true,
                    'attributes' => array('size' => 40)
                )
            )
        );
        $f = new Form('/submit', 'post', $fields);
        $this->assertEquals(4, count($f->getFields()));
        $this->assertTrue($f->hasFile());
    }

    public function testAddFields()
    {
        $fields = array(
            'username' => array(
                'type'       => 'text',
                'value'      => 'Username here...',
                'label'      => 'Username:',
                'required'   => true,
                'attributes' => array('size' => 40)
            )
        );
        $f = new Form('/submit', 'post');
        $f->addFields($fields);
        $this->assertEquals(1, count($f->getFields()));
    }

    public function testRemoveElement()
    {
        $fields = array(
            'username' => array(
                'type'       => 'text',
                'value'      => 'Username here...',
                'label'      => 'Username:',
                'required'   => true,
                'attributes' => array('size' => 40)
            ),
            'email' => array(
                'type'       => 'text',
                'label'      => 'Email:',
                'required'   => true,
                'attributes' => array('size' => 40)
            )
        );
        $f = new Form('/submit', 'post');
        $f->addFields($fields);
        $f->removeElement('username');
        $this->assertEquals(1, count($f->getFields()));
    }

    public function testRemoveArrayOfElements()
    {
        $fields = array(
            array(
                'username' => array(
                    'type'       => 'text',
                    'value'      => 'Username here...',
                    'label'      => 'Username:',
                    'required'   => true,
                    'attributes' => array('size' => 40)
                )
            ),
            array(
                'email1' => array(
                    'type'       => 'text',
                    'label'      => 'Email 1:',
                    'required'   => true,
                    'attributes' => array('size' => 40)
                ),
                'email2' => array(
                    'type'       => 'text',
                    'label'      => 'Email 1:',
                    'required'   => true,
                    'attributes' => array('size' => 40)
                )
            )
        );
        $f = new Form('/submit', 'post');
        $f->addFields($fields);
        $f->removeElement('username');
        $this->assertEquals(2, count($f->getFields()));
    }

    public function testSetFieldValues()
    {
        $fields = array(
            'username' => array(
                'type'       => 'text',
                'value'      => 'Username here...',
                'label'      => 'Username:',
                'required'   => true,
                'attributes' => array('size' => 40),
                'error'      => array(
                    'h3'  => array('class' => 'error-class'),
                    'pre' => true
                ),
                'validators' => new \Pop\Validator\AlphaNumeric()
            ),
            'checkbox' => array(
                'type'       => 'checkbox',
                'value'      => array(0 => 'Test1', 1 => 'Test2', 2 => 'Test3'),
                'label'      => 'Checkbox:',
                'marked'     => array(0, 1),
                'required'   => true
            ),
            'radio' => array(
                'type'       => 'radio',
                'value'      => array(0 => 'Test1', 1 => 'Test2', 2 => 'Test3'),
                'label'      => 'Radio:',
                'marked'     => 0,
                'required'   => true
            ),
            'select' => array(
                'type'       => 'select',
                'value'      => array(0 => 'Test1', 1 => 'Test2', 2 => 'Test3'),
                'label'      => 'Select:',
                'marked'     => 0,
                'required'   => true
            ),
            'textarea' => array(
                'type'       => 'textarea',
                'label'      => 'Textarea:',
                'required'   => true,
                'attributes' => array('rows' => 40),
                'validators' => array(new \Pop\Validator\AlphaNumeric(), new \Pop\Validator\LengthGt(6))
            )
        );
        $f = new Form('/submit', 'post', $fields);
        $f->setFieldValues(
            array('username' => '<p>te\'st"<script>user</script></p>'),
            array(
                'strip_tags'   => '<p>',
                'htmlentities' => array(ENT_QUOTES, 'UTF-8')
            )
        );
        $this->assertEquals('&lt;p&gt;te&#039;st&quot;user&lt;/p&gt;', $f->username);
    }

    public function testFilter()
    {
        $fields = array(
            'username' => array(
                'type'       => 'text',
                'value'      => 'Username here...',
                'label'      => 'Username:',
                'required'   => true,
                'attributes' => array('size' => 40)
            )
        );
        $f = new Form('/submit', 'post', $fields);
        $f->setFieldValues(
            array('username' => '<p>te\'st"<script>user</script></p>'),
            array(
                'strip_tags'   => '<p>',
                'htmlentities' => array(ENT_QUOTES, 'UTF-8')
            )
        );
        $this->assertEquals('&lt;p&gt;te&#039;st&quot;user&lt;/p&gt;', $f->username);
        $f->filter(array(
            'html_entity_decode' => array(ENT_QUOTES, 'UTF-8')
        ));
        $this->assertEquals('<p>te\'st"user</p>', $f->username);
    }

    public function testSetAndGetAction()
    {
        $f = new Form('/submit', 'post');
        $f->setAction('/action');
        $this->assertEquals('/action', $f->getAction());
    }

    public function testSetAndGetMethod()
    {
        $f = new Form('/submit', 'post');
        $f->setMethod('get');
        $this->assertEquals('get', $f->getMethod());
    }

    public function testGetFormElement()
    {
        $f = new Form('/submit', 'post');
        $this->assertInstanceOf('Pop\Dom\Child', $f->getFormElement());
    }

    public function testSetAndGetTemplate()
    {
        $f = new Form('/submit', 'post');
        $f->setTemplate(__DIR__ . '/../../../../../public/examples/form/form.phtml');
        $f->setTemplate('This is the template');
        $this->assertEquals('This is the template', $f->getTemplate());
        $f->setTemplate(__DIR__ . '/../tmp/access.txt');
        $this->assertContains('testuser', $f->getTemplate());
    }

    public function testSetAndGetAttributes()
    {
        $f = new Form('/submit', 'post');
        $f->setAttributes('id', 'test-form');
        $this->assertEquals(3, count($f->getAttributes()));
    }

    public function testAddAndGetElements()
    {
        $e = new Element('text', 'username', 'Username');
        $f = new Form('/submit', 'post');
        $f->addElements($e);
        $this->assertEquals(1, count($f->getElements()));
        $this->assertInstanceOf('Pop\Form\Element', $f->getElement('username'));
    }

    public function testAddElements()
    {
        $e = new Element('text', 'username', 'Username');
        $c = new Checkbox('colors', array('Red', 'Green', 'Blue'));
        $r = new Radio('colors', array('Red', 'Green', 'Blue'));
        $s = new Select('colors', array('Red', 'Green', 'Blue'));
        $t = new Textarea('comments');
        $f = new Form('/submit', 'post');
        $f->addElements($e);
        $f->addElements(array($c, $r, $s, $t));
        $this->assertEquals(5, count($f->getElements()));
        $this->assertInstanceOf('Pop\Form\Element', $f->getElement('username'));
        $this->assertTrue($f->isValid());
        $this->assertEquals(0, count($f->getErrors()));
    }

    public function testRemoveElements()
    {
        $e = new Element('text', 'username', 'Username');
        $c = new Checkbox('colors', array('Red', 'Green', 'Blue'));
        $r = new Radio('colors', array('Red', 'Green', 'Blue'));
        $f = new Form('/submit', 'post');
        $f->addElements(array($e, $c, $r));
        $f->removeElement('username');
        $f->removeElement('colors');
        $this->assertEquals(1, count($f->getFields()));
    }

    public function testRender()
    {
        $e = new Element('text', 'username', 'Username');
        $e->setLabel('Username');
        $s = new Element('submit', 'submit', 'Submit');
        $f = new Form('/submit', 'post');
        $f->addElements(array($e, $s));
        $form = $f->render(true);
        $this->assertContains('<form ', $form);

        $f = new Form('/submit', 'post');
        $f->addElements(array($e, $s));
        ob_start();
        $f->render();
        $output = ob_get_clean();
        $this->assertContains('<form ', $output);

        $f = new Form('/submit', 'post');
        $f->addElements(array($e, $s));
        $this->assertContains('<form ', (string)$f);
    }

    public function testRenderWithTemplate()
    {
        $e = new Element('text', 'username', 'Username');
        $e->setLabel('Username');
        $s = new Element('submit', 'submit', 'Submit');
        $f = new Form('/submit', 'post');
        $f->addElements(array($e, $s));
        $f->setTemplate("[{username}] [{submit}]");
        $f->username = 'My Username';
        $form = $f->render(true);
        $this->assertContains('<form ', $form);
        $this->assertEquals('My Username', $f->username);
    }

    public function testRenderException()
    {
        $this->setExpectedException('Pop\Form\Exception');
        $f = new Form('/submit', 'post');
        $f->render();
    }

}

