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

use Pop\Validator\Validator;

/**
 * This is the Fields class for the Form component.
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT   T  New BSD License
 * @version    1.0.2
 */
class Fields
{

    /**
     * Fields array
     * @var array
     */
    protected $fields = array();

    /**
     * Constructor
     *
     * Instantiate the fields object
     *
     * @param  mixed $fields
     * @param  array $attribs
     * @param  array $value
     * @param  mixed $omit
     * @return void
     */
    public function __construct($fields = null, array $attribs = null, array $values = null, $omit = null)
    {
        if (null !== $fields) {
            if ($fields instanceof \Pop\Record\Record) {
                $this->addFieldsFromTable($fields, $attribs, $values, $omit);
            } else {
                $this->addFields($fields);
            }
        }
    }

    /**
     * Static method to instantiate the fields object and return itself
     * to facilitate chaining methods together.
     *
     * @param  mixed $fields
     * @param  array $attribs
     * @param  array $value
     * @param  mixed $omit
     * @return Pop\Form\Fields
     */
    public static function factory($fields = null, array $attribs = null, array $values = null, $omit = null)
    {
        return new self($fields, $attribs, $values, $omit);
    }

    /**
     * Add form fields
     *
     * @param  array $fields
     * @return Pop\Form\Fields
     */
    public function addFields($fields)
    {
        $isArray = true;
        foreach ($fields as $key => $value) {
            if (!is_array($value)) {
                $isArray = false;
            }
        }

        if (!$isArray) {
            $fields = array($fields);
        }

        $this->fields = array_merge($this->fields, $fields);
    }

    /**
     * Add form fields from a related database table
     *
     * @param  Pop\Record\Record $tableObj
     * @param  array             $attribs
     * @param  array             $value
     * @param  mixed             $omit
     * @return Pop\Form\Fields
     */
    public function addFieldsFromTable(\Pop\Record\Record $tableObj, array $attribs = null, array $values = null, $omit = null)
    {
        $tableInfo = $tableObj->getTableInfo();

        if (null !== $omit) {
            if (!is_array($omit)) {
                $omit = array($omit);
            }
        } else {
            $omit = array();
        }

        foreach ($tableInfo['columns'] as $key => $value) {
            if (!in_array($key, $omit)) {
                $fieldName = $key;
                $fieldValue = null;
                $fieldLabel = null;
                $required = ($value['null']) ? false : true;
                $attributes = null;
                $marked = null;
                $validators = (isset($values[$key]['validators'])) ? $values[$key]['validators'] : null;

                $fieldType = (stripos($key, 'password') !== false) ?
                    'password' :
                    ((stripos($value['type'], 'text' !== false)) ? 'textarea' : 'text');

                if ((null !== $values) && isset($values[$key])) {
                    if (isset($values[$key]['type'])) {
                        $fieldType = $values[$key]['type'];
                    }
                    $fieldValue = (isset($values[$key]['value'])) ? $values[$key]['value'] : null;
                    if ((!$_POST) && !isset($_GET[$key])) {
                        $marked = (isset($values[$key]['marked'])) ? $values[$key]['marked'] : null;
                    }
                }

                if ($fieldType != 'hidden') {
                    $fieldLabel = ucwords(str_replace('_', ' ', $key)) . ':';
                } else {
                    if ((null === $fieldValue) && ($required)) {
                        $fieldValue = '0';
                    }
                }

                if (null !== $attribs) {
                    if (isset($attribs[$fieldType])) {
                        $attributes =  $attribs[$fieldType];
                    }
                }

                if ((stripos($key, 'email') !== false) || (stripos($key, 'e-mail') !== false) || (stripos($key, 'e_mail') !== false)) {
                    $validators = new Validator\Email();
                }

                $this->fields[] = array(
                    'type'       => $fieldType,
                    'name'       => $fieldName,
                    'label'      => $fieldLabel,
                    'value'      => $fieldValue,
                    'required'   => $required,
                    'attributes' => $attributes,
                    'marked'     => $marked,
                    'validators' => $validators
                );
            }
        }

        return $this;
    }

    /**
     * Get the form fields
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

}
