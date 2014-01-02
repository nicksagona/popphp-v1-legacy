<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Form;

/**
 * Form fields class
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
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
     * @param  array $values
     * @param  mixed $omit
     * @return \Pop\Form\Fields
     */
    public function __construct($fields = null, array $attribs = null, array $values = null, $omit = null)
    {
        if (null !== $fields) {
            if (is_array($fields) && isset($fields['tableName'])) {
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
     * @param  array $values
     * @param  mixed $omit
     * @return \Pop\Form\Fields
     */
    public static function factory($fields = null, array $attribs = null, array $values = null, $omit = null)
    {
        return new self($fields, $attribs, $values, $omit);
    }

    /**
     * Add form fields
     *
     * @param  array $fields
     * @return \Pop\Form\Fields
     */
    public function addFields(array $fields)
    {
        $this->fields = array_merge($this->fields, $fields);
        return $this;
    }

    /**
     * Add form fields from a related database table. The $tableInfo
     * parameter should be the returned array result from calling the
     * static Pop\Db\Record method, Record::getTableInfo();
     *
     * @param  array $tableInfo
     * @param  array $attribs
     * @param  array $values
     * @param  mixed $omit
     * @throws Exception
     * @return \Pop\Form\Fields
     */
    public function addFieldsFromTable(array $tableInfo, array $attribs = null, array $values = null, $omit = null)
    {
        if (!isset($tableInfo['tableName']) || !isset($tableInfo['primaryId']) || !isset($tableInfo['columns'])) {
            throw new Exception('Error: The table info parameter is not in the correct format. It should be a returned array value from the getTableInfo() method of the Record component.');
        }

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
                    ((stripos($value['type'], 'text') !== false) ? 'textarea' : 'text');

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
                    $validators = new \Pop\Validator\Email();
                }

                $this->fields[$fieldName] = array(
                    'type'       => $fieldType,
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
