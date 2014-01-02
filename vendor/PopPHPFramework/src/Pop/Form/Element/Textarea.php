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
namespace Pop\Form\Element;

/**
 * Textarea form element class
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Textarea extends \Pop\Form\Element
{

    /**
     * Constructor
     *
     * Instantiate the textarea form element object.
     *
     * @param  string $name
     * @param  string $value
     * @param  string|array $marked
     * @param  string $indent
     * @return \Pop\Form\Element\Textarea
     */
    public function __construct($name, $value = null, $marked = null, $indent = null)
    {
        parent::__construct('textarea', $name, $value, $marked, $indent);
    }

}
