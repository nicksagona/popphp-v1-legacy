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
 * @package    Pop_Dom
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_Dom_Abstract
 *
 * @category   Pop
 * @package    Pop_Dom
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

abstract class Pop_Dom_Abstract
{

    /**
     * Object child nodes
     * @var array
     */
    protected $_childNodes = array();

    /**
     * Indentation for formatting purposes.
     * @var string
     */
    protected $_indent = null;

    /**
     * Child output
     * @var string
     */
    protected $_output = null;

    /**
     * Language object
     * @var Pop_Locale
     */
    protected $_lang = null;

    /**
     * Method to return the indent.
     *
     * @return void
     */
    public function getIndent()
    {
        return $this->_indent;
    }

    /**
     * Method to set the indent.
     *
     * @param  string $indent
     * @return void
     */
    public function setIndent($indent)
    {
        $this->_indent = $indent;
    }

    /**
     * Add a child to the object.
     *
     * @param  array|Pop_Dom_Child $c
     * @throws Exception
     * @return void
     */
    public function addChild($c)
    {
        if ($c instanceof Pop_Dom_Child) {
            $this->_childNodes[] = $c;
        } else if (is_array($c)) {
            $this->_childNodes[] = Pop_Dom_Child::factory($c);
        } else {
            throw new Exception($this->_lang->__('The argument passed is not valid.'));
        }
    }

    /**
     * Add children to the object.
     *
     * @param  array $c
     * @throws Exception
     * @return void
     */
    public function addChildren($c)
    {
        foreach ($c as $child) {
            $this->addChild($child);
        }
    }

    /**
     * Get the child nodes of the object.
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->_childNodes;
    }

    /**
     * Remove all child nodes from the object.
     *
     * @return void
     */
    public function removeChildren()
    {
        $this->_childNodes = array();
    }

}
