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
namespace Pop\Form\Element;

use Pop\Form\Element;

/**
 * This is the Radio Element class for the Form component.
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.2
 */
class Radio extends Element
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
     * @return void
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
