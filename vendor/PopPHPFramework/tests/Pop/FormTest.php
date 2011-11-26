<?php
/**
 * Pop PHP Framework
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
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

require_once dirname(__FILE__) . '/../../library/Pop/Autoloader.php';
Pop_Autoloader::bootstrap();

class Pop_FormTest extends PHPUnit_Framework_TestCase
{

    public function testFormConstructor()
    {
        $f = new Pop_Form('action.php', 'post');
        $class = 'Pop_Form';
        $this->assertTrue($f instanceof $class);
    }

    public function testFormSetTemplate()
    {
        $f = new Pop_Form('action.php', 'post');
        $tmpl = "<table><tr><td>FORM TEMPLATE</td></tr><table>";
        $f->setTemplate($tmpl);
        $this->assertEquals($tmpl, $f->getTemplate());
    }

    public function testFormSetAttributes()
    {
        $f = new Pop_Form('action.php', 'post');
        $f->setAttributes('id', 'loginForm');
        $attributes = $f->getAttributes();
        $this->assertTrue(array_key_exists('id', $attributes));
        $this->assertTrue(in_array('loginForm', $attributes));
    }

    public function testFormSetElements()
    {
        $f = new Pop_Form('action.php', 'post');
        $name = new Pop_Form_Element('text', 'name', '');
        $f->addElements($name);
        $elements = $f->getElements();
        $class = 'Pop_Form_Element';
        $this->assertTrue($elements[0] instanceof $class);
    }

    public function testFormElementConstructor()
    {
        $f = new Pop_Form_Element('text', 'email', '');
        $class = 'Pop_Form_Element';
        $this->assertTrue($f instanceof $class);
    }

    public function testFormElementSetAttributes()
    {
        $f = new Pop_Form_Element('text', 'email', '');
        $attribute = 'class';
        $value = 'red';
        $f->setAttributes($attribute, $value);
        $attributes = $f->getAttributes();
        $this->assertTrue(array_key_exists($attribute, $attributes));
        $this->assertTrue(in_array($value, $attributes));
    }

    public function testFormElementSetLabel()
    {
        $f = new Pop_Form_Element('text', 'email', '');
        $label = 'email';
        $f->setLabel($label);
        $this->assertEquals($label, $f->label);
    }

    public function testFormElementSetRequired()
    {
        $f = new Pop_Form_Element('text', 'email', '');
        $f->setRequired(true);
        $this->assertTrue($f->required);
    }

    public function testFormElementAddValidator()
    {
        $f = new Pop_Form_Element('text', 'email', '');
        $validator = 'Alpha';
        $f->addValidator($validator);
        $this->assertTrue(array_key_exists('type', $f->validators[0]));
        $this->assertTrue(in_array('Alpha', $f->validators[0]));
    }

}

?>