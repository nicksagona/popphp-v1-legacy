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
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Form;

use Pop\Dom\Child,
    Pop\Locale\Locale,
    Pop\Validator\Validator,
    Pop\Validator\Validator\ValidatorInterface;

/**
 * This is the Element class for the Form component.
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0
 */
class Element extends Child
{

    /**
     * Element name
     * @var string
     */
    public $name = null;

    /**
     * Form element value(s)
     * @var string|array
     */
    public $value = null;

    /**
     * Form element marked value(s)
     * @var string|array
     */
    public $marked = null;

    /**
     * Form element label
     * @var string
     */
    public $label = null;

    /**
     * Form element required property
     * @var boolean
     */
    public $required = false;

    /**
     * Form element validators
     * @var array
     */
    public $validators = array();

    /**
     * Form element errors
     * @var array
     */
    public $errors = array();

    /**
     * Form element allowed types
     * @var array
     */
    protected $allowed_types = array(
        'button',
        'checkbox',
        'file',
        'hidden',
        'image',
        'password',
        'radio',
        'reset',
        'select',
        'submit',
        'text',
        'textarea'
    );

    /**
     * Constructor
     *
     * Instantiate the form element object
     *
     * @param  string $type
     * @param  string $name
     * @param  string $value
     * @param  string|array $marked
     * @param  string $indent
     * @throws Exception
     * @return void
     */
    public function __construct($type, $name, $value = null, $marked = null, $indent = null)
    {
        $this->name = $name;

        // Check the element type, else set the properties.
        if (!in_array($type, $this->allowed_types)) {
            throw new Exception('Error: That input type is not allowed.');
        }

        // Create the element based on the type passed.
        switch ($type) {
            // Textarea element
            case 'textarea':
                parent::__construct('textarea', null, null, false, $indent);
                $this->setAttributes(array('name' => $name, 'id' => $name));
                $this->nodeValue = $value;
                $this->value = $value;
                break;

            // Select element
            case 'select':
                parent::__construct('select', null, null, false, $indent);
                $this->setAttributes(array('name' => $name, 'id' => $name));

                // Create the child option elements.
                foreach ($value as $k => $v) {
                    $opt = new Child('option', null, null, false, $indent);
                    $opt->setAttributes('value', $k);

                    // Determine if the current option element is selected.
                    if ($v == $this->marked) {
                        $opt->setAttributes('selected', 'selected');
                    }

                    $opt->setNodeValue($v);
                    $this->addChild($opt);
                }

                $this->value = $value;
                break;

            // Radio element(s)
            case 'radio':
                parent::__construct('fieldset', null, null, false, $indent);
                $this->setAttributes('class', 'radioBtnArea');

                // Create the radio elements and related span elements.
                $i = null;
                foreach ($value as $k => $v) {
                    $rad = new Child('input', null, null, false, $indent);
                    $rad->setAttributes(array(
                        'type' => $type,
                        'class' => 'radioBtn',
                        'name' => $name,
                        'id' => ($name . $i),
                        'value' => $k
                    ));

                    // Determine if the current radio element is checked.
                    if ($v == $this->marked) {
                        $rad->setAttributes('checked', 'checked');
                    }

                    $span = new Child('span', null, null, false, $indent);
                    $span->setAttributes('class', 'radioPad');
                    $span->setNodeValue($v);
                    $this->addChildren(array($rad, $span));
                    $i++;
                }

                $this->value = $value;
                break;

            // Checkbox element(s)
            case 'checkbox':
                parent::__construct('fieldset', null, null, false, $indent);
                $this->setAttributes('class', 'checkBoxArea');

                // Create the checkbox elements and related span elements.
                $i = null;
                foreach ($value as $k => $v) {
                    $chk = new Child('input', null, null, false, $indent);
                    $chk->setAttributes(array(
                        'type' => $type,
                        'class' => 'checkBox',
                        'name' => ($name . '[]'),
                        'id' => ($name . $i),
                        'value' => $k
                    ));

                    // Determine if the current radio element is checked.
                    if (in_array($v, $this->marked)) {
                        $chk->setAttributes('checked', 'checked');
                    }

                    $span = new Child('span', null, null, false, $indent);
                    $span->setAttributes('class', 'checkPad');
                    $span->setNodeValue($v);
                    $this->addChildren(array($chk, $span));
                    $i++;
                }

                $this->value = $value;
                break;

            // Input element
            default:
                parent::__construct('input', null, null, false, $indent);
                $this->setAttributes(array('type' => $type, 'name' => $name, 'id' => $name));
                if (!is_array($value)) {
                    $this->setAttributes('value', $value);
                }
                $this->value = $value;
        }

        // If a certain value is marked (selected or checked), set the property here.
        if (null !== $marked) {
            $this->marked = $marked;
        }
    }

    /**
     * Set the label of the form element object.
     *
     * @param  string $label
     * @return Pop\Form\Element
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Set whether the form element object is required.
     *
     * @param  boolean $required
     * @throws Exception
     * @return Pop\Form\Element
     */
    public function setRequired($required)
    {
        $this->required = (boolean)$required;
        return $this;
    }

    /**
     * Add a validator the form element object.
     *
     * @param  ValidatorInterface $validator
     * @param  string $msg
     * @return Pop\Form\Element
     */
    public function addValidator(ValidatorInterface $validator, $msg = null)
    {
        $this->validators[] = new Validator($validator, $msg);
        return $this;
    }

    /**
     * Validate the form element object.
     *
     * @return boolean
     */
    public function validate()
    {
        $this->errors = array();

        // Check if the element is required.
        if ($this->required == true) {
            $curElemValue = (is_array($this->value)) ? $this->marked : $this->value;
            if (empty($curElemValue)) {
                $this->errors[] = Locale::factory()->__('This field is required.');
            }
        }

        // Check the element's validators.
        if (isset($this->validators[0])) {
            foreach ($this->validators as $validator) {
                $curElemValue = (is_array($this->value)) ? $this->marked : $this->value;
                if (!$validator->evaluate($curElemValue)) {
                    $this->errors[] = $validator->getMessage();
                }
            }
        }

        // If errors are found on any of the form elements, return false.
        return (count($this->errors) > 0) ? false : true;
    }


    /**
     * Method to render the child and its child nodes.
     *
     * @param  boolean $ret
     * @param  int     $depth
     * @param  string  $indent
     * @param  string  $errorIndent
     * @return string
     */
    public function render($ret = false, $depth = 0, $indent = null, $errorIndent = null)
    {
        $output = parent::render(true, $depth, $indent);

        // Add error messages if there are any.
        if (count($this->errors) > 0) {
            foreach ($this->errors as $msg) {
                $output .= "{$errorIndent}{$indent}{$this->indent}<div class=\"error\">{$msg}</div>\n";
            }
        }

        return $output;
    }


    /**
     * Method to render the child and its child nodes.
     *
     * @return string
     */
    public function output()
    {
        echo $this->render();
    }

}
