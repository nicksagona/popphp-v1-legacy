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

/**
 * Pop_Form_Element
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Form_Element extends Pop_Dom_Child
{

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
    protected $_allowed_types = array('button', 'checkbox', 'file', 'hidden', 'image', 'password', 'radio', 'reset', 'select', 'submit', 'text', 'textarea');

    /**
     * Form element allowed validators
     * @var array
     */
    protected $_allowed_validators = array('AlphaNum', 'Alpha', 'Between', 'Email', 'Equal', 'GreaterThan', 'Length', 'LengthBet', 'LengthGT', 'LengthLT', 'LessThan', 'NotEmpty', 'NotEqual', 'Num', 'RegEx');

    /**
     * Language object
     * @var Pop_Locale
     */
    protected $_lang = null;

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
        $this->_lang = new Pop_Locale();

        // Check the element type, else set the properties.
        if (!in_array($type, $this->_allowed_types)) {
            throw new Exception($this->_lang->__('Error: That input type is not allowed.'));
        } else {
            // Create the element based on the type passed.
            switch ($type) {
                // Textarea element
                case 'textarea':
                    parent::__construct('textarea', null, null, false, $indent);
                    $this->setAttributes(array('name' => $name, 'id' => $name));
                    $this->_nodeValue = $value;
                    $this->value = $value;
                    break;

                // Select element
                case 'select':
                    parent::__construct('select', null, null, false, $indent);
                    $this->setAttributes(array('name' => $name, 'id' => $name));

                    // Create the child option elements.
                    foreach ($value as $k => $v) {

                        $opt = new Pop_Dom_Child('option', null, null, false, ($indent . '    '));
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

                        $rad = new Pop_Dom_Child('input', null, null, false, ($indent . '    '));
                        $rad->setAttributes(array('type' => $type, 'class' => 'radioBtn', 'name' => $name, 'id' => ($name . $i), 'value' => $k));

                        // Determine if the current radio element is checked.
                        if ($v == $this->marked) {
                            $rad->setAttributes('checked', 'checked');
                        }

                        $span = new Pop_Dom_Child('span', null, null, false, ($indent . '    '));
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

                        $chk = new Pop_Dom_Child('input', null, null, false, ($indent . '    '));
                        $chk->setAttributes(array('type' => $type, 'class' => 'checkBox', 'name' => ($name . '[]'), 'id' => ($name . $i), 'value' => $k));

                        // Determine if the current radio element is checked.
                        if (in_array($v, $this->marked)) {
                            $chk->setAttributes('checked', 'checked');
                        }

                        $span = new Pop_Dom_Child('span', null, null, false, ($indent . '    '));
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
        }

        // If a certain value is marked (selected or checked), set the property here.
        if (!is_null($marked)) {
            $this->marked = $marked;
        }
    }

    /**
     * Set the label of the form element object.
     *
     * @param  string $l
     * @return void
     */
    public function setLabel($l)
    {
        $this->label = $l;
    }

    /**
     * Set whether the form element object is required.
     *
     * @param  boolean $r
     * @throws Exception
     * @return void
     */
    public function setRequired($r)
    {
        if (!is_bool($r)) {
            throw new Exception($this->_lang->__('Error: The required flag must be a boolean value.'));
        } else {
            $this->required = $r;
        }
    }

    /**
     * Add a validator the form element object.
     *
     * @param  string $type
     * @param  boolean $condition
     * @param  string $value
     * @param  string $msg
     * @throws Exception
     * @return void
     */
    public function addValidator($type, $condition = true, $value = null, $msg = null)
    {
        // Check the validator type and condition, else set the properties.
        if (!in_array($type, $this->_allowed_validators)) {
            throw new Exception($this->_lang->__('Error: That type validator is not allowed.'));
        } else if (!is_bool($condition)) {
            throw new Exception($this->_lang->__('Error: The condition must be a boolean.'));
        } else {
            $this->validators[] = array('type' => $type,
                                        'condition' => $condition,
                                        'value' => $value,
                                        'msg' => $msg);
        }
    }

    /**
     * Validate the form element object.
     *
     * @return boolean
     */
    public function validate()
    {
        // Check if the element is required.
        if ($this->required == true) {
            $curElemValue = (is_array($this->value)) ? $this->marked : $this->value;

            if (empty($curElemValue)) {
                $this->errors['Required'] = $this->_lang->__('This field is required.');
            } else {
                unset($this->errors['Required']);
            }
        }

        // Check the element's validators.
        if (isset($this->validators[0])) {
            foreach ($this->validators as $value) {
                $curElemValue = (is_array($this->value)) ? $this->marked : $this->value;

                switch ($value['type']) {
                    // Alphanumeric pattern.
                    case 'AlphaNum':
                        if (!empty($curElemValue)) {
                            if (preg_match('/^\w+$/', $curElemValue) == $value['condition']) {
                                unset($this->errors['AlphaNum']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['AlphaNum'] = $value['msg'];
                                } else {
                                    $this->errors['AlphaNum'] = $this->_lang->__('This field value must %1 contain alphanumeric characters.', (($value['condition'] == true) ? $this->_lang->__('only') : $this->_lang->__('not')));
                                }
                            }
                        }
                        break;

                    // Alpha-only pattern.
                    case 'Alpha':
                        if (!empty($curElemValue)) {
                            if (preg_match('/^[a-zA-Z]+$/', $curElemValue) == $value['condition']) {
                                unset($this->errors['Alpha']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['Alpha'] = $value['msg'];
                                } else {
                                    $this->errors['Alpha'] = $this->_lang->__('This field value must %1 contain characters of the alphabet.', (($value['condition'] == true) ? $this->_lang->__('only') : $this->_lang->__('not')));
                                }
                            }
                        }
                        break;

                    // Between two values.
                    case 'Between':
                        if (!empty($curElemValue)) {
                            $numAry = explode('|', $value['value']);
                            if ((($curElemValue > $numAry[0]) && ($curElemValue < $numAry[1])) == $value['condition']) {
                                unset($this->errors['Between']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['Between'] = $value['msg'];
                                } else {
                                    $this->errors['Between'] = $this->_lang->__('This field value is %1 between %2 and %3.', array((($value['condition'] == true) ? 'not' : ''), $numAry[0], $numAry[1]));
                                }
                            }
                        }
                        break;

                    // E-mail pattern.
                    case 'Email':
                        if (!empty($curElemValue)) {
                            if (preg_match('/[a-zA-Z0-9\.\-\_+%]+@[a-zA-Z0-9\-\_\.]+\.[a-zA-Z]{2,4}/', $curElemValue) == $value['condition']) {
                                unset($this->errors['Email']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['Email'] = $value['msg'];
                                } else {
                                    $this->errors['Email'] = $this->_lang->__('This field value format is %1 a correct email format.', (($value['condition'] == true) ? 'not' : ''));
                                }
                            }
                        }
                        break;

                    // Equal to value.
                    case 'Equal':
                        if (!empty($curElemValue)) {
                            if (($curElemValue == $value['value']) == $value['condition']) {
                                unset($this->errors['Equal']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['Equal'] = $value['msg'];
                                } else {
                                    $this->errors['Equal'] = $this->_lang->__('This field value does not equal the correct value.');
                                }
                            }
                        }
                        break;

                    // Greater than value.
                    case 'GreaterThan':
                        if (!empty($curElemValue)) {
                            if (($curElemValue > $value['value']) == $value['condition']) {
                                unset($this->errors['GreaterThan']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['GreaterThan'] = $value['msg'];
                                } else {
                                    $this->errors['GreaterThan'] = $this->_lang->__('This field value is %1 greater than %2.', array((($value['condition'] == true) ? 'not' : ''), $value['value']));
                                }
                            }
                        }
                        break;

                    // String length equals value.
                    case 'Length':
                        if (!empty($curElemValue)) {
                            if ((strlen($curElemValue) == $value['value']) == $value['condition']) {
                                unset($this->errors['Length']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['Length'] = $value['msg'];
                                } else {
                                    $this->errors['Length'] = $this->_lang->__('This field value length is %1 equal to %2 characters long.', array((($value['condition'] == true) ? 'not' : ''), $value['value']));
                                }
                            }
                        }
                        break;

                    // String length between two values.
                    case 'LengthBet':
                        if (!empty($curElemValue)) {
                            $numAry = explode('|', $value['value']);
                            if (((strlen($curElemValue) > $numAry[0]) && (strlen($curElemValue) < $numAry[1])) == $value['condition']) {
                                unset($this->errors['LengthBet']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['LengthBet'] = $value['msg'];
                                } else {
                                    $this->errors['LengthBet'] = $this->_lang->__('This field value length is %1 between %2 and %3.', array((($value['condition'] == true) ? 'not' : ''), $numAry[0], $numAry[1]));
                                }
                            }
                        }
                        break;

                    // String length greater than value.
                    case 'LengthGT':
                        if (!empty($curElemValue)) {
                            if ((strlen($curElemValue) >= $value['value']) == $value['condition']) {
                                unset($this->errors['LengthGT']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['LengthGT'] = $value['msg'];
                                } else {
                                    $this->errors['LengthGT'] = $this->_lang->__('This field value length must be %1 %2 characters long.', array((($value['condition'] == true) ? 'at least' : 'under'), $value['value']));
                                }
                            }
                        }
                        break;

                    // String length less than value.
                    case 'LengthLT':
                        if (!empty($curElemValue)) {
                            if ((strlen($curElemValue) <= $value['value']) == $value['condition']) {
                                unset($this->errors['LengthLT']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['LengthLT'] = $value['msg'];
                                } else {
                                    $this->errors['LengthLT'] = $this->_lang->__('This field value length must be %1 %2 characters long.', array((($value['condition'] == true) ? 'under' : 'at least'), $value['value']));
                                }
                            }
                        }
                        break;

                    // Less than value.
                    case 'LessThan':
                        if (!empty($curElemValue)) {
                            if (($curElemValue < $value['value']) == $value['condition']) {
                                unset($this->errors['LessThan']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['LessThan'] = $value['msg'];
                                } else {
                                    $this->errors['LessThan'] = $this->_lang->__('This field value is %1 less than %2.', array((($value['condition'] == true) ? 'not' : ''), $value['value']));
                                }
                            }
                        }
                        break;

                    // Value not empty.
                    case 'NotEmpty':
                        if ((!empty($curElemValue)) == $value['condition']) {
                            unset($this->errors['NotEmpty']);
                        } else {
                            if (!is_null($value['msg'])) {
                                $this->errors['NotEmpty'] = $value['msg'];
                            } else {
                                $this->errors['NotEmpty'] = $this->_lang->__('This field value is %1 empty.', (($value['condition'] == true) ? '' : 'not'));
                            }
                        }
                        break;

                    // Not equal to value.
                    case 'NotEqual':
                        if (!empty($curElemValue)) {
                            if (($curElemValue != $value['value']) == $value['condition']) {
                                unset($this->errors['NotEqual']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['NotEqual'] = $value['msg'];
                                } else {
                                    $this->errors['NotEqual'] = $this->_lang->__('This field value does not equal the correct value.');
                                }
                            }
                        }
                        break;

                    // Numeric value.
                    case 'Num':
                        if (!empty($curElemValue)) {
                            if ((is_numeric($curElemValue)) == $value['condition']) {
                                unset($this->errors['Num']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['Num'] = $value['msg'];
                                } else {
                                    $this->errors['Num'] = $this->_lang->__('This field value is %1 a number.', (($value['condition'] == true) ? 'not' : ''));
                                }
                            }
                        }
                        break;

                    // Value matches regular expression.
                    case 'RegEx':
                        if (!empty($curElemValue)) {
                            if (preg_match($value['value'], $curElemValue) == $value['condition']) {
                                unset($this->errors['RegEx']);
                            } else {
                                if (!is_null($value['msg'])) {
                                    $this->errors['RegEx'] = $value['msg'];
                                } else {
                                    $this->errors['RegEx'] = $this->_lang->__('This field value format is %1 correct.', (($value['condition'] == true) ? 'not' : ''));
                                }
                            }
                        }
                        break;
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
     * @param  int $depth
     * @param  string $indent
     * @return void
     */
    public function render($ret = false, $depth = 0, $indent = null)
    {
        $output = parent::render(true);

        // Add error messages if there are any.
        if (count($this->errors) > 0) {
            foreach ($this->errors as $msg) {
                $output .= "{$indent}{$this->_indent}<div class=\"error\">{$msg}</div>\n";
            }
        }

        return $output;
    }

}
