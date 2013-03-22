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
 * Radio form element class
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.3
 */
class Radio extends \Pop\Form\Element
{

    /**
     * Current values
     * @var array
     */
    public $values = array();

    /**
     * Constructor
     *
     * Instantiate the radio form element object.
     *
     * @param  string $name
     * @param  string|array $value
     * @param  string|array $marked
     * @param  string $indent
     * @return \Pop\Form\Element\Radio
     */
    public function __construct($name, $value = null, $marked = null, $indent = null)
    {
        $this->values = $value;
        $this->setMarked($marked);

        parent::__construct('radio', $name, $value, $marked, $indent);
    }

    /**
     * Set the current marked value. The marked value is based on the key of the associative array (not the value.)
     *
     * @param  string $val
     * @return void
     */
    public function setMarked($val)
    {
        $this->marked = null;

        if (array_key_exists($val, $this->values) !==  false) {
            $this->marked = $this->values[$val];
        }
    }

}
