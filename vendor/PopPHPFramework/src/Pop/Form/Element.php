<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Form;

use Pop\Dom\Child,
    Pop\Validator;

/**
 * Form element class
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
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
     * @return \Pop\Form\Element
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
                    if (is_array($this->marked)) {
                        if (in_array($v, $this->marked)) {
                            $opt->setAttributes('selected', 'selected');
                        }
                    } else {
                        if ($v == $this->marked) {
                            $opt->setAttributes('selected', 'selected');
                        }
                    }

                    $opt->setNodeValue($v);
                    $this->addChild($opt);
                }

                $this->value = $value;
                break;

            // Radio element(s)
            case 'radio':
                parent::__construct('fieldset', null, null, false, $indent);
                $this->setAttributes('class', 'radio-btn-fieldset');

                // Create the radio elements and related span elements.
                $i = null;
                foreach ($value as $k => $v) {
                    $rad = new Child('input', null, null, false, $indent);
                    $rad->setAttributes(array(
                        'type' => $type,
                        'class' => 'radio-btn',
                        'name' => $name,
                        'id' => ($name . $i),
                        'value' => $k
                    ));

                    // Determine if the current radio element is checked.
                    if ($v == $this->marked) {
                        $rad->setAttributes('checked', 'checked');
                    }

                    $span = new Child('span', null, null, false, $indent);
                    $span->setAttributes('class', 'radio-span');
                    $span->setNodeValue($v);
                    $this->addChildren(array($rad, $span));
                    $i++;
                }

                $this->value = $value;
                break;

            // Checkbox element(s)
            case 'checkbox':
                parent::__construct('fieldset', null, null, false, $indent);
                $this->setAttributes('class', 'check-box-fieldset');

                // Create the checkbox elements and related span elements.
                $i = null;
                foreach ($value as $k => $v) {
                    $chk = new Child('input', null, null, false, $indent);
                    $chk->setAttributes(array(
                        'type' => $type,
                        'class' => 'check-box',
                        'name' => ($name . '[]'),
                        'id' => ($name . $i),
                        'value' => $k
                    ));

                    // Determine if the current radio element is checked.
                    if (in_array($v, $this->marked)) {
                        $chk->setAttributes('checked', 'checked');
                    }

                    $span = new Child('span', null, null, false, $indent);
                    $span->setAttributes('class', 'check-span');
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
     * @return \Pop\Form\Element
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
     * @return \Pop\Form\Element
     */
    public function setRequired($required)
    {
        $this->required = (boolean)$required;
        return $this;
    }

    /**
     * Add a validator the form element object.
     *
     * @param  \Pop\Validator\ValidatorInterface $validator
     * @return \Pop\Form\Element
     */
    public function addValidator(Validator\ValidatorInterface $validator)
    {
        $this->validators[] = $validator;
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
            if (is_array($this->value)) {
                $curElemValue = $this->marked;
            } else if (isset($_FILES[$this->name]['name'])) {
                $curElemValue = $_FILES[$this->name]['name'];
            } else {
                $curElemValue = $this->value;
            }

            if (empty($curElemValue) && ($curElemValue != '0')) {
                $this->errors[] = \Pop\Locale\Locale::factory()->__('This field is required.');
            }
        }

        // Check the element's validators.
        if (isset($this->validators[0])) {
            foreach ($this->validators as $validator) {
                //$curElemValue = (is_array($this->value)) ? $this->marked : $this->value;
                if (is_array($this->value)) {
                    $curElemValue = $this->marked;
                } else if (isset($_FILES[$this->name]['name'])) {
                    $curElemValue = $_FILES[$this->name]['name'];
                } else {
                    $curElemValue = $this->value;
                }

                if ('Pop\Validator\NotEmpty' == get_class($validator)) {
                    if (!$validator->evaluate($curElemValue)) {
                        $this->errors[] = $validator->getMessage();
                    }
                } else {
                    if (!empty($curElemValue) && !$validator->evaluate($curElemValue)) {
                        $this->errors[] = $validator->getMessage();
                    }
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
