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
    Pop\File\File,
    Pop\Filter\String,
    Pop\Form\Element,
    Pop\Form\Element\Checkbox,
    Pop\Form\Element\Radio,
    Pop\Form\Element\Select,
    Pop\Form\Element\Textarea;

/**
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT   T  New BSD License
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
     * Form init field values
     * @var array
     */
    protected $_initFieldsValues = array();

    /**
     * Constructor
     *
     * Instantiate the form object
     *
     * @param  string $action
     * @param  string $method
     * @param  array  $fields
     * @param  string $indent
     * @return void
     */
    public function __construct($action, $method, array $fields = null, $indent = null)
    {
        // Set the form's action and method.
        $this->_action = $action;
        $this->_method = $method;

        // Create the parent DOM element and the form child element.
        parent::__construct(null, 'utf-8', null, $indent);
        $this->_form = new Child('form', null, null, false, $indent);
        $this->_form->setAttributes(array('action' => $this->_action, 'method' => $this->_method));
        $this->addChild($this->_form);

        if (null !== $fields) {
            $this->setFields($fields);
        }
    }

    /**
     * Set the fields of the form object.
     *
     * @param  array $fields
     * @throws Exception
     * @return Pop\Form\Form
     */
    public function setFields(array $fields)
    {
        if (isset($fields[0]) && !is_array($fields[0])) {
            throw new Exception('The array parameter passed must contain an array of field values.');
        }
        $this->_initFieldsValues = $fields;
        return $this;
    }

    /**
     * Get the form fields
     *
     * @return array
     */
    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * Set the field values
     *
     * @param  array $values
     * @param  mixed $filters
     * @return Pop\Form\Form
     */
    public function setFieldValues(array $values = null, $filters = null)
    {
        // Filter values if passed
        if ((null !== $values) && (null !== $filters)) {
            $values = $this->_filterValues($values, $filters);
        }

        // Loop through the initial fields values and build the fields
        // based on the _initFieldsValues property.
        if (isset($this->_initFieldsValues[0])) {
            foreach ($this->_initFieldsValues as $field) {
                if (is_array($field) && isset($field['type']) && isset($field['name'])) {
                    $type = $field['type'];
                    $name = $field['name'];
                    $label = (isset($field['label'])) ? $field['label'] : null;
                    $required = (isset($field['required'])) ? $field['required'] : null;
                    $attributes = (isset($field['attributes'])) ? $field['attributes'] : null;
                    $validators = (isset($field['validators'])) ? $field['validators'] : null;

                    if ((null !== $values) && array_key_exists($name, $values)) {
                        if (($type == 'checkbox') || ($type == 'radio') || ($type == 'select')) {
                            $value = (isset($field['value'])) ? $field['value'] : null;
                            $marked = $values[$name];
                        } else {
                            $value = $values[$name];
                            $marked = (isset($field['marked'])) ? $field['marked'] : null;
                        }
                    } else {
                        $value = (isset($field['value'])) ? $field['value'] : null;
                        $marked = (isset($field['marked'])) ? $field['marked'] : null;
                    }
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
                                $elem->addValidator($val);
                            }
                        } else {
                            $elem->addValidator($validators);
                        }
                    }

                    $this->addElements($elem);
                }
            }
        // Else, set the passed values to the elements that
        // are already added to the form object
        } else {
            $fields = $this->getElements();
            if ((null !== $values) && (count($fields) > 0)) {
                foreach ($fields as $field) {
                    // If a multi-value form element
                    if (isset($values[$field->name])) {
                        if (isset($field->values)) {
                            $field->marked = $values[$field->name];
                            $this->_fields[$field->name] = $values[$field->name];
                            // Loop through the field's children
                            if ($field->hasChildren()) {
                                $children = $field->getChildren();
                                foreach ($children as $key => $child) {
                                    // If checkbox or radio
                                    if (($child->getAttribute('type') == 'checkbox') || ($child->getAttribute('type') == 'radio')) {
                                        if (is_array($field->marked) && in_array($child->getAttribute('value'), $field->marked)) {
                                            $field->getChild($key)->setAttributes('checked', 'checked');
                                        } else if ($child->getAttribute('value') == $field->marked) {
                                            $field->getChild($key)->setAttributes('checked', 'checked');
                                        }
                                    // If select option
                                    } else if ($child->getNodeName() == 'option') {
                                        if ($child->getAttribute('value') == $field->marked) {
                                            $field->getChild($key)->setAttributes('selected', 'selected');
                                        }
                                    }
                                }
                            }
                        // Else, if a single-value form element
                        } else {
                            $field->value = $values[$field->name];
                            $this->_fields[$field->name] = $values[$field->name];
                            if ($field->getNodeName() == 'textarea') {
                                $field->setNodeValue($values[$field->name]);
                            } else {
                                $field->setAttributes('value', $values[$field->name]);
                            }
                        }
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Set a form template for the render method to utilize.
     *
     * @param  string $tmpl
     * @return Pop\Form\Form
     */
    public function setTemplate($tmpl)
    {
        if (file_exists($tmpl)) {
            $tmplFile = new File($tmpl);
            $this->_template = $tmplFile->read();
        } else {
            $this->_template = $tmpl;
        }
        return $this;
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
     * @return Pop\Form\Form
     */
    public function setAttributes($a, $v = null)
    {
        $this->_form->setAttributes($a, $v);
        return $this;
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
     * @return Pop\Form\Form
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

        return $this;
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
     * Get an element of the form object by name.
     *
     * @param string $elementName
     * @return array
     */
    public function getElement($elementName)
    {
        $name = null;
        $elem = null;
        $index = null;
        $elems =  $this->_form->getChildren();

        foreach ($elems as $i => $e) {
            if ($e->getNodeName() == 'fieldset') {
                $children = $e->getChildren();
                foreach ($children as $c) {
                    if ($c->getNodeName() == 'input') {
                        $attribs = $c->getAttributes();
                        $name = str_replace('[]', '', $attribs['name']);
                    }
                }
            } else {
                $attribs = $e->getAttributes();
                $name = $attribs['name'];
            }
            if ($name == $elementName) {
                $index = $i;
                $elem = $e;
            }
        }

        return $elem;
    }

    /**
     * Get the index of an element of the form object by name.
     *
     * @param string $elementName
     * @return array
     */
    public function getElementIndex($elementName)
    {
        $name = null;
        $elem = null;
        $index = null;
        $elems =  $this->_form->getChildren();

        foreach ($elems as $i => $e) {
            if ($e->getNodeName() == 'fieldset') {
                $children = $e->getChildren();
                foreach ($children as $c) {
                    if ($c->getNodeName() == 'input') {
                        $attribs = $c->getAttributes();
                        $name = str_replace('[]', '', $attribs['name']);
                    }
                }
            } else {
                $attribs = $e->getAttributes();
                $name = $attribs['name'];
            }
            if ($name == $elementName) {
                $index = $i;
                $elem = $e;
            }
        }

        return $index;
    }

    /**
     * Determine whether or not the form object is valid and return the result.
     *
     * @return boolean
     */
    public function isValid()
    {
        $noErrors = true;
        $children = $this->_form->getChildren();

        // Check each element for validators, validate them and return the result.
        foreach ($children as $child) {
            if ($child->validate() == false) {
                $noErrors = false;
            }
        }

        return $noErrors;
    }

    /**
     * Render the form object either using the defined template or by a basic
     * 1:1 DL/DD tag structure. The template should use a simple search and
     * replace format that contains [{element}] and/or [{element_label}] for
     * the placeholders that will be swapped out. Required fields' labels have
     * have class="required" and error messages have class="error" for
     * styling purposes.
     *
     * @param  boolean $ret
     * @throws Exception
     * @return void
     */
    public function render($ret = false)
    {
        // Check to make sure form elements exist.
        if ((count($this->_form->getChildren()) == 0) && (count($this->_initFieldsValues) == 0)) {
            throw new Exception('Error: There are no form elements declared for this form object.');
        } else if ((count($this->_form->getChildren()) == 0) && (count($this->_initFieldsValues) > 0)) {
            $this->setFieldValues();
        }

        // If the template is not set, default to the basic output.
        if (null === $this->_template) {
            $this->_renderWithoutTemplate();
        // Else, start building the form's HTML output based on the template.
        } else {
            $this->_renderWithTemplate();
        }

        // Return or print the form output.
        if ($ret) {
            return $this->_output;
        } else {
            echo $this->_output;
        }

    }

    /**
     * Method to filter the values
     *
     * @param  array $values
     * @param  mixed $filters
     * @return array
     */
    protected function _filterValues($values, $filters)
    {
        $filteredValues = array();

        if (!is_array($filters)) {
            $filters = array($filters);
        }

        foreach ($values as $key => $value) {
            foreach ($filters as $filter) {
                if (method_exists('Pop\\Filter\\String', $filter)) {
                    if (is_array($value)) {
                        $filteredAry = array();
                        foreach ($value as $k => $v) {
                            $filteredAry[$k] = (string)String::factory($v)->$filter();
                        }
                        $filteredValues[$key] = $filteredAry;
                    } else {
                        $filteredValues[$key] = (string)String::factory($value)->$filter();
                    }
                } else {
                    $filteredValues[$key] = $value;
                }
            }
        }

        return $filteredValues;
    }

    /**
     * Method to render the form using a basic 1:1 DD/DL layout
     *
     * @return void
     */
    protected function _renderWithoutTemplate()
    {
        // Initialize properties.
        $this->_output = null;
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
    }

    /**
     * Method to render the form using the template
     *
     * @return void
     */
    protected function _renderWithTemplate()
    {
        // Initialize properties and variables.
        $this->_output = null;
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
        $this->_output = $this->_form->render(true);
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
        return $this->render(true);
    }

}
