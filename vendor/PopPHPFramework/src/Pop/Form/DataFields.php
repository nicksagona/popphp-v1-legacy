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

/**
 * This is the DataFields class for the Form component.
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT   T  New BSD License
 * @version    1.0.2
 */
class DataFields
{

    /**
     * Get the form fields from a related database table
     *
     * @param Pop\Record\Record $tableObj
     * @param array             $attribs
     * @param array             $value
     * @param mixed             $omit
     * @return array
     */
    public static function getFields($tableObj, array $attribs = null, array $values = null, $omit = null)
    {
        $fields = array();
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
                $validators = null;

                $fieldType = (stripos($key, 'password') !== false) ?
                	'password' :
                    ((stripos($value['type'], 'text' !== false)) ? 'textarea' : 'text');

                if ((null !== $values) && isset($values[$key])) {
                    if (isset($values[$key]['type'])) {
                        $fieldType = $values[$key]['type'];
                    }
                    $fieldValue = (isset($values[$key]['value'])) ? $values[$key]['value'] : null;
                    $marked = (isset($values[$key]['marked'])) ? $values[$key]['marked'] : null;
                }
                if ($fieldType != 'hidden') {
                    $fieldLabel = ucwords(str_replace('_', ' ', $key)) . ':';
                }

                if (null !== $attribs) {
                    if (isset($attribs[$fieldType])) {
                        $attributes =  $attribs[$fieldType];
                    }
                }

                $fields[] = array(
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
        
        return $fields;

    }

}
