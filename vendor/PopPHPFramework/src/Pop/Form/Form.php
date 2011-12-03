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

use Pop\Dom\Dom,
    Pop\Dom\Child,
    Pop\Form\Element,
    Pop\Form\Element\Checkbox,
    Pop\Form\Element\Radio,
    Pop\Form\Element\Select,
    Pop\Form\Element\Textarea,
    Pop\Locale\Locale,
    Pop\Filter\String;

/**
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Form extends Dom
{

    /**
     * Form element node
     * @var Child
     */
    protected $_form = null;

    /**
     * Form action
     * @var string
     */
    protected $_action = null;

    /**
     * Form method
     * @var string
     */
    protected $_method = null;

    /**
     * Form template for HTML formatting.
     * @var string
     */
    protected $_template = null;

    /**
     * Field names of the database table
     * @var array
     */
    protected $_fields = array();

    /**
     * Form init values for quick setup
     * @var array
     */
    protected $_initValues = array();

    /**
     * Constructor
     *
     * Instantiate the form object
     *
     * @param  string $action
     * @param  string $method
     * @param  string $indent
     * @return void
     */
    public function __construct($action, $method, $indent = null)
    {
        // Set the form's action and method.
        $this->_action = $action;
        $this->_method = $method;

        // Create the parent DOM element and the form child element.
        parent::__construct(null, 'utf-8', null, $indent);
        $this->_form = new Child('form', null, null, false, $indent);
        $this->_form->setAttributes(array('action' => $this->_action, 'method' => $this->_method));
        $this->addChild($this->_form);
    }

    /**
     * Set the init values of the form object.
     *
     * @param  array $values
     * @throws Exception
     * @return void
     */
    public function setInitValues($values)
    {
        if (!is_array($values)) {
            throw new Exception(Locale::factory()->__('The parameter passed must be an array.'));
        } if (isset($values[0]) && !is_array($values[0])) {
            throw new Exception(Locale::factory()->__('The array parameter passed must contain an array.'));
        } else {
            $this->_initValues = $values;
        }
    }

    /**
     * Generate the form field elements based on the _initValues property.
     *
     * @return void
     */
    public function generateFields()
    {
        if (isset($this->_initValues[0])) {
            foreach ($this->_initValues as $field) {
                if (is_array($field) && isset($field['type']) && isset($field['name'])) {
                    $type = $field['type'];
                    $name = $field['name'];
                    $value = (isset($field['value'])) ? $field['value'] : null;
                    $marked = (isset($field['marked'])) ? $field['marked'] : null;
                    $label = (isset($field['label'])) ? $field['label'] : null;
                    $required = (isset($field['required'])) ? $field['required'] : null;
                    $attributes = (isset($field['attributes'])) ? $field['attributes'] : null;
                    $validators = (isset($field['validators'])) ? $field['validators'] : null;

                    // Initialize the form element.
                    switch ($type) {
                        case 'checkbox':
                            $elem = new Checkbox($name, $value, $marked);
                            break;
                        case 'radio':
                            $elem = new Radio($name, $value, $marked);
                            break;
                        case 'select':
                            $elem = new Select($name, $value, $marked);
                            break;
                        case 'textarea':
                            $elem = new Textarea($name, $value, $marked);
                            break;
                        default:
                            $elem = new Element($type, $name, $value, $marked);
                    }

                    // Set the label.
                    if (null !== $label) {
                        $elem->setLabel($label);
                    }

                    // Set if required.
                    if (null !== $required) {
                        $elem->setRequired($required);
                    }

                    // Set any attributes.
                    if (null !== $attributes) {
                        if (is_array($attributes)) {
                            if ((count($attributes) == 2) && !is_array($attributes[0]) && !is_array($attributes[1])) {
                                $elem->setAttributes($attributes[0], $attributes[1]);
                            } else {
                                foreach ($attributes as $att) {
                                    if (isset($att[0]) && isset($att[1])) {
                                        $elem->setAttributes($att[0], $att[1]);
                                    }
                                }
                            }
                        }
                    }

                    // Set any validators.
                    if (null !== $validators) {
                        if (is_array($validators)) {
                            foreach ($validators as $val) {
                                if (is_array($val)) {
                                    $cond = (isset($val[1])) ? $val[1] : true;
                                    $value = (isset($val[2])) ? $val[2] : null;
                                    $msg = (isset($val[3])) ? $val[3] : null;
                                    $elem->addValidator($val[0], $cond, $value, $msg);
                                } else {
                                    $elem->addValidator($val);
                                }
                            }
                        } else {
                            $elem->addValidator($validators);
                        }
                    }

                    $this->addElements($elem);
                }
            }
        }
    }

    /**
     * Set fields values based on the array passed, $_POST or $_GET.
     *
     * @param  array $values
     * @param  boolean $filter
     * @return void
     */
    public function setFieldValues($values, $filter = false)
    {
        $elements = $this->_form->getChildren();
        // Set values into the _initValues property.
        if (isset($this->_initValues[0]) && (!isset($elements[0]))) {
            foreach ($this->_initValues as $key => $field) {
                if (isset($field['name']) && isset($values[$field['name']])) {
                    if (($field['type'] == 'select') || ($field['type'] == 'checkbox') || ($field['type'] == 'radio')) {
                        $this->_initValues[$key]['marked'] = $values[$field['name']];
                    } else {
                        $this->_initValues[$key]['value'] = ($filter) ? (string)String::factory($values[$field['name']])->striptags() : $values[$field['name']];
                    }
                }
            }
        // Else, if elements have already been created, set field values into those elements.
        } else {
            foreach ($elements as $key => $field) {
                $attributes = $field->getAttributes();
                if (isset($attributes['name']) && isset($values[$attributes['name']])) {
                    // If a select element.
                    if ($field instanceof Select) {
                        $elements[$key]->setMarked($values[$attributes['name']]);
                        $elements[$key]->removeChildren();
                        foreach ($elements[$key]->value as $k => $v) {
                            $opt = new Child('option');
                            $opt->setAttributes('value', $k);
                            if ($v == $elements[$key]->marked) {
                                $opt->setAttributes('selected', 'selected');
                            }
                            $opt->setNodeValue($v);
                            $elements[$key]->addChild($opt);
                        }
                    // If a textarea element.
                    } else if ($field instanceof Textarea) {
                        $val = ($filter) ? (string)String::factory($values[$attributes['name']])->striptags() : $values[$attributes['name']];
                        $elements[$key]->value = $val;
                        $elements[$key]->setNodeValue($val);
                    // If an input element.
                    } else {
                        $val = ($filter) ? (string)String::factory($values[$attributes['name']])->striptags() : $values[$attributes['name']];
                        $elements[$key]->value = $val;
                        $elements[$key]->setAttributes('value', $val);
                    }
                // If a checkbox element.
                } else if ($field instanceof Checkbox) {
                    $children = $field->getChildren();
                    $atts = $children[0]->getAttributes();
                    $name = str_replace('[]', '', $atts['name']);
                    if (isset($values[$name])) {
                        $elements[$key]->setMarked($values[$name]);
                        $elements[$key]->removeChildren();
                        $i = null;
                        foreach ($elements[$key]->value as $k => $v) {
                            $chk = new Child('input');
                            $chk->setAttributes(array('type' => 'checkbox', 'class' => 'checkBox', 'name' => ($name . '[]'), 'id' => ($name . $i), 'value' => $k));
                            if (in_array($v, $elements[$key]->marked)) {
                                $chk->setAttributes('checked', 'checked');
                            }
                            $span = new Child('span');
                            $span->setAttributes('class', 'checkPad');
                            $span->setNodeValue($v);
                            $elements[$key]->addChildren(array($chk, $span));
                            $i++;
                        }
                    }
                // If a radio element.
                } else if ($field instanceof Radio) {
                    $children = $field->getChildren();
                    $atts = $children[0]->getAttributes();
                    $name = $atts['name'];
                    if (isset($values[$name])) {
                        $elements[$key]->setMarked($values[$name]);
                        $elements[$key]->removeChildren();
                        $i = null;
                        foreach ($elements[$key]->value as $k => $v) {
                            $rad = new Child('input');
                            $rad->setAttributes(array('type' => 'radio', 'class' => 'radioBtn', 'name' => $name, 'id' => ($name . $i), 'value' => $k));
                            if ($v == $elements[$key]->marked) {
                                $rad->setAttributes('checked', 'checked');
                            }
                            $span = new Child('span');
                            $span->setAttributes('class', 'radioPad');
                            $span->setNodeValue($v);
                            $elements[$key]->addChildren(array($rad, $span));
                            $i++;
                        }
                    }
                }
            }
            $this->_form->removeChildren();
            $this->_form->addChildren($elements);
        }
    }

    /**
     * Set a form template for the render method to utilize.
     *
     * @param  string $tmpl
     * @return void
     */
    public function setTemplate($tmpl)
    {
        $this->_template = $tmpl;
    }

    /**
     * Get the form template for the render method to utilize.
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * Set an attribute or attributes for the form object.
     *
     * @param  array|string $a
     * @param  string $v
     * @return void
     */
    public function setAttributes($a, $v = null)
    {
        $this->_form->setAttributes($a, $v);
    }

    /**
     * Get the attributes of the form object.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->_form->getAttributes();
    }

    /**
     * Add a form element or elements to the form object.
     *
     * @param  array|string $e
     * @return void
     */
    public function addElements($e)
    {
        if (is_array($e)) {
            $this->_form->addChildren($e);
        } else {
            $this->_form->addChild($e);
        }

        $children = $this->_form->getChildren();

        foreach ($children as $child) {
            $attribs = $child->getAttributes();
            if ($child instanceof Textarea) {
                if (isset($attribs['name'])) {
                    $this->_fields[$attribs['name']] = (isset($child->value) ? $child->value : null);
                }
            } else if ($child instanceof Select) {
                if (isset($attribs['name'])) {
                    $this->_fields[$attribs['name']] = (isset($child->marked) ? $child->marked : null);
                }
            } else if ($child instanceof Radio) {
                $radioChildren = $child->getChildren();
                $childAttribs = $radioChildren[0]->getAttributes();
                if (isset($childAttribs['name'])) {
                    $this->_fields[$childAttribs['name']] = (isset($child->marked) ? $child->marked : null);
                }
            } else if ($child instanceof Checkbox) {
                $radioChildren = $child->getChildren();
                $childAttribs = $radioChildren[0]->getAttributes();
                if (isset($childAttribs['name'])) {
                    $key = str_replace('[]', '', $childAttribs['name']);
                    $this->_fields[$key] = (isset($child->marked) ? $child->marked : null);
                }
            } else {
                if (isset($attribs['name'])) {
                    $this->_fields[$attribs['name']] = (isset($attribs['value']) ? $attribs['value'] : null);
                }
            }
        }
    }

    /**
     * Get the elements of the form object.
     *
     * @return array
     */
    public function getElements()
    {
        return $this->_form->getChildren();
    }

    /**
     * Determine whether or not the form object is valid and return the result.
     *
     * @return boolean
     */
    public function isValid()
    {
        $noerrors = true;
        $children = $this->_form->getChildren();

        // Check each element for validators, validate them and return the result.
        foreach ($children as $child) {
            if ($child->validate() == false) {
                $noerrors = false;
            }
        }

        return $noerrors;
    }

    /**
     * Render the form object using the defined template. The template should use a simple search and replace
     * format that contains [{element}] and/or [{element_label}] for the placeholders that will be swapped out.
     * Required fields' labels have class="required" and error messages have class="error" for styling purposes.
     *
     * @param  boolean $ret
     * @throws Exception
     * @return void
     */

    public function render($ret = false)
    {
        // Check to make sure form elements exist.
        if (count($this->_form->getChildren()) == 0) {
            throw new Exception(Locale::factory()->__('Error: There are no form elements declared for this form object.'));
        // Else, if the template is not set, default to the basic output.
        } else if (null === $this->_template) {
            if ($ret) {
                return (string)$this;
            } else {
                echo $this;
            }
        // Else, start building the form's HTML output based on the template.
        } else {
            // Initialize properties and variabels.
            $this->_output = '';
            $children = $this->_form->getChildren();

            // Loop through the child elements of the form.
            foreach ($children as $child) {
                // Get the element name.
                if ($child->getNodeName() == 'fieldset') {
                    $chdrn = $child->getChildren();
                    $attribs = $chdrn[0]->getAttributes();
                } else {
                    $attribs = $child->getAttributes();
                }
                $name = (isset($attribs['name'])) ? $attribs['name'] : '';
                $name = str_replace('[]', '', $name);

                // Set the element's label, if applicable.
                if (null !== $child->label) {

                    // Format the label name.
                    $label = new Child('label', $child->label);

                    if ($child->required) {
                        $label->setAttributes(array('for' => $name, 'class' => 'required'));
                    } else {
                        $label->setAttributes('for', $name);
                    }

                    // Swap the element's label placeholder with the rendered label element.
                    $labelSearch = '[{' . $name . '_label}]';
                    $labelReplace = $label->render(true);
                    $this->_template = str_replace($labelSearch, substr($labelReplace, 0, -1), $this->_template);
                }

                // Calculate the element's indentation.
                $indent = '';
                $indent = substr($this->_template, 0, strpos($this->_template, ('[{' . $name . '}]')));
                $indent = substr($indent, (strrpos($indent, "\n") + 1));

                $matches = array();
                preg_match_all('/[^\s]/', $indent, $matches);
                if (isset($matches[0])) {
                    foreach ($matches[0] as $str) {
                        $indent = str_replace($str, ' ', $indent);
                    }
                }

                // Set each child element's indentation.
                $childChildren = $child->getChildren();
                $child->removeChildren();
                foreach ($childChildren as $cChild) {
                    $cChild->setIndent(($indent . '    '));
                    $child->addChild($cChild);
                }

                // Swap the element's placeholder with the rendered element.
                $elementSearch = '[{' . $name . '}]';
                $elementReplace = $child->render(true, 0, $indent);
                $elementReplace = substr($elementReplace, 0, -1);
                $elementReplace = str_replace('</select>', $indent . '</select>', $elementReplace);
                $elementReplace = str_replace('</fieldset>', $indent . '</fieldset>', $elementReplace);
                $this->_template = str_replace($elementSearch, $elementReplace, $this->_template);
            }

            // Set the rendered form content and remove the children.
            $this->_form->setNodeValue("\n" . $this->_template . "\n" . $this->_form->getIndent());
            $this->_form->removeChildren();

            // Return or print the form output.
            if ($ret) {
                return $this->_form->render(true);
            } else {
                echo $this->_form->render(true);
            }
        }
    }

    /**
     * Set method to set the property to the value of _fields[$name].
     *
     * @param  string $name
     * @param  mixed $value
     * @throws Exception
     * @return void
     */
    public function __set($name, $value)
    {
        $this->_fields[$name] = $value;
    }

    /**
     * Get method to return the value of _fields[$name].
     *
     * @param  string $name
     * @throws Exception
     * @return mixed
     */
    public function __get($name)
    {
        return (!array_key_exists($name, $this->_fields)) ? null : $this->_fields[$name];
    }

    /**
     * Output the form object in a basic HTML format. Each form element is formatted to a 1:1 label to element
     * ratio, using <dl>, <dt> and <dd> tags. Required fields' labels have class="required" and error messages
     * have class="error" for styling purposes.
     *
     * @return string
     */

    public function __toString()
    {
        // Initialize propeties.
        $this->_output = '';
        $children = $this->_form->getChildren();
        $this->_form->removeChildren();

        // Create DL element.
        $dl = new Child('dl', null, null, false, ($this->_form->getIndent() . '    '));

        // Loop through the children and create and attach the appropriate DT and DT elements, with labels where applicable.
        foreach ($children as $child) {
            // If the element label is set, render the appropriate DT and DD elements.
            if (null !== $child->label) {
                // Create the DT and DD elements.
                $dt = new Child('dt', null, null, false, ($this->_form->getIndent() . '        '));
                $dd = new Child('dd', null, null, false, ($this->_form->getIndent() . '        '));

                // Format the label name.
                $lbl_name = ($child->getNodeName() == 'fieldset') ? '1' : '';
                $label = new Child('label', $child->label, null, false, ($this->_form->getIndent() . '            '));

                if ($child->getNodeName() == 'fieldset') {
                    $chdrn = $child->getChildren();
                    $attribs = $chdrn[0]->getAttributes();
                } else {
                    $attribs = $child->getAttributes();
                }

                $name = (isset($attribs['name'])) ? $attribs['name'] : '';
                $name = str_replace('[]', '', $name);

                if ($child->required) {
                    $label->setAttributes(array('for' => ($name . $lbl_name), 'class' => 'required'));
                } else {
                    $label->setAttributes('for', ($name . $lbl_name));
                }

                // Add the appropriate children to the appropriate elements.
                $dt->addChild($label);
                $child->setIndent(($this->_form->getIndent() . '            '));
                $childChildren = $child->getChildren();
                $child->removeChildren();

                foreach ($childChildren as $cChild) {
                    $cChild->setIndent(($this->_form->getIndent() . '                '));
                    $child->addChild($cChild);
                }

                $dd->addChild($child);
                $dl->addChildren(array($dt, $dd));
            // Else, render only a DD element.
            } else {
                $dd = new Child('dd', null, null, false, ($this->_form->getIndent() . '        '));
                $child->setIndent(($this->_form->getIndent() . '            '));
                $dd->addChild($child);
                $dl->addChild($dd);
            }
        }

        // Add the DL element and its children to the form element.
        $this->_form->addChild($dl);
        $this->_output = $this->_form->render(true);

        // Print the output.
        return $this->_output;
    }

}
