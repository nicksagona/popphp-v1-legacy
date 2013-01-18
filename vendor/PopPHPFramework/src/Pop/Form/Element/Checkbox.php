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
namespace Pop\Form\Element;

/**
 * This is the Checkbox Element class for the Form component.
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.2.0
 */
class Checkbox extends \Pop\Form\Element
{

    /**
     * Current values
     * @var array
     */
    public $values = array();

    /**
     * Constructor
     *
     * Instantiate the checkbox form element object.
     *
     * @param  string $name
     * @param  string|array $value
     * @param  string|array $marked
     * @param  string $indent
     * @return \Pop\Form\Element\Checkbox
     */
    public function __construct($name, $value = null, $marked = null, $indent = null)
    {
        $this->values = $value;
        $this->setMarked($marked);

        parent::__construct('checkbox', $name, $value, $marked, $indent);
    }

    /**
     * Set the current marked value. The marked value is based on the key(s) of the associative array (not the value(s).)
     *
     * @param  string|array $val
     * @return void
     */
    public function setMarked($val)
    {
        $this->marked = array();

        if (is_array($val)) {
            foreach ($val as $v) {
                if (array_key_exists($v, $this->values) !==  false) {
                    $this->marked[] = $this->values[$v];
                }
            }
        } else {
            if (array_key_exists($val, $this->values) !==  false) {
                $this->marked[] = $this->values[$val];
            }
        }
    }

}
