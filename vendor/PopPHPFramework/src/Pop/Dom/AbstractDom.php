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
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Dom;

/**
 * This is the abstract class for the Dom component.
 *
 * @category   Pop
 * @package    Pop_Dom
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.3
 */
abstract class AbstractDom
{

    /**
     * Object child nodes
     * @var array
     */
    protected $childNodes = array();

    /**
     * Indentation for formatting purposes.
     * @var string
     */
    protected $indent = null;

    /**
     * Child output
     * @var string
     */
    protected $output = null;

    /**
     * Method to return the indent.
     *
     * @return void
     */
    public function getIndent()
    {
        return $this->indent;
    }

    /**
     * Method to set the indent.
     *
     * @param  string $indent
     * @return mixed
     */
    public function setIndent($indent)
    {
        $this->indent = $indent;
        return $this;
    }

    /**
     * Add a child to the object.
     *
     * @param  mixed $c
     * @throws Exception
     * @return mixed
     */
    public function addChild($c)
    {
        if ($c instanceof Child) {
            $this->childNodes[] = $c;
        } else if (is_array($c)) {
            $this->childNodes[] = Child::factory($c);
        } else {
            throw new Exception('The argument passed is not valid.');
        }

        return $this;
    }

    /**
     * Add children to the object.
     *
     * @param  array $c
     * @throws Exception
     * @return mixed
     */
    public function addChildren($c)
    {
        foreach ($c as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * Get whether or not the child object has children
     *
     * @return boolean
     */
    public function hasChildren()
    {
        return (count($this->childNodes) > 0) ? true : false;
    }

    /**
     * Get the child nodes of the object.
     *
     * @param int $i
     * @return \Pop\Dom\Child
     */
    public function getChild($i)
    {
        return (isset($this->childNodes[(int)$i])) ? $this->childNodes[(int)$i] : null;
    }

    /**
     * Get the child nodes of the object.
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->childNodes;
    }

    /**
     * Remove all child nodes from the object.
     *
     * @param  int  $i
     * @return void
     */
    public function removeChild($i)
    {
        if (isset($this->childNodes[$i])) {
            unset($this->childNodes[$i]);
        }
    }

    /**
     * Remove all child nodes from the object.
     *
     * @return void
     */
    public function removeChildren()
    {
        $this->childNodes = array();
    }

}
