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
 * Pop_Dom_Child
 *
 * @category   Pop
 * @package    Pop_Dom
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Dom_Child extends Pop_Dom_Abstract
{

    /**
     * Child element node name
     * @var string
     */
    protected $_nodeName = null;

    /**
     * Child element node value
     * @var string
     */
    protected $_nodeValue = null;

    /**
     * Flag to render children before node value or not.
     * @var boolean
     */
    protected $_childrenFirst = false;

    /**
     * Child element attributes
     * @var array
     */
    protected $_attributes = array();

    /**
     * Constructor
     *
     * Instantiate the form element object
     *
     * @param  string $name
     * @param  string $value
     * @param  array|Pop_Dom_Child $childNode
     * @param  boolean $first
     * @param  string $indent
     * @return void
     */
    public function __construct($name, $value = null, $childNode = null, $first = false, $indent = null)
    {
        $this->_lang = new Pop_Locale();

        $this->_nodeName = $name;
        $this->_nodeValue = $value;
        $this->_childrenFirst = $first;

        if (!is_null($childNode)) {
            $this->addChild($childNode);
        }

        $this->_indent = $indent;
    }

    /**
     * Static factory method to create child objects
     *
     * @param  array $c
     * @return Pop_Dom_Child
     */
    public static function factory(array $c)
    {
        $nodeName = $c['nodeName'];
        $nodeValue = (isset($c['nodeValue']) ? $c['nodeValue'] : null);
        $childFirst = (isset($c['childrenFirst']) ? $c['childrenFirst'] : false);
        $indent = (isset($c['indent']) ? $c['indent'] : null);

        $child = new Pop_Dom_Child($nodeName, $nodeValue, null, $childFirst, $indent);
        if (isset($c['attributes'])) {
            $child->setAttributes($c['attributes']);
        }

        if (isset($c['childNodes'])) {
            $child->addChildren($c['childNodes']);
        }

        return $child;
    }

    /**
     * Method to return the child node name.
     *
     * @return void
     */
    public function getNodeName()
    {
        return $this->_nodeName;
    }

    /**
     * Method to return the child node value.
     *
     * @return void
     */
    public function getNodeValue()
    {
        return $this->_nodeValue;
    }

    /**
     * Method to set the child node name.
     *
     * @param  string $name
     * @return void
     */
    public function setNodeName($name)
    {
        $this->_nodeName = $name;
    }

    /**
     * Method to set the child node value.
     *
     * @param  string $name
     * @return void
     */

    public function setNodeValue($value)
    {
        $this->_nodeValue = $value;
    }

    /**
     * Set an attribute or attributes for the child element object.
     *
     * @param  array|string $a
     * @param  string $v
     * @return void
     */
    public function setAttributes($a, $v = null)
    {
        if (is_array($a)) {
            foreach ($a as $name => $value) {
                $this->_attributes[$name] = $value;
            }
        } else {
            $this->_attributes[$a] = $v;
        }
    }

    /**
     * Get the attributes of the child object.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }

    /**
     * Method to render the child and its child nodes.
     *
     * @param  boolean $ret
     * @param  int $depth
     * @param  string $indent
     * @return void
     */
    public function render($ret = false, $depth = 0, $indent = null)
    {
        // Initialize child object properties and variables.
        $this->_output = '';
        $this->_indent = (is_null($this->_indent)) ? str_repeat('    ', $depth) : $this->_indent;
        $attribs = '';
        $attribAry = array();

        // Format child attributes, if applicable.
        if (count($this->_attributes) > 0) {
            foreach ($this->_attributes as $key => $value) {
                $attribAry[] = $key . "=\"" . $value . "\"";
            }
            $attribs = ' ' . implode(' ', $attribAry);
        }

        // Initialize the node.
        $this->_output .= "{$indent}{$this->_indent}<{$this->_nodeName}{$attribs}";

        // If current child element has child nodes, format and render.
        if (count($this->_childNodes) > 0) {
            $this->_output .= ">\n";
            $new_depth = $depth + 1;

            // Render node value before the child nodes.
            if (!$this->_childrenFirst) {
                $this->_output .= (!is_null($this->_nodeValue)) ? (str_repeat('    ', $new_depth) . "{$indent}{$this->_nodeValue}\n") : '';
                foreach ($this->_childNodes as $child) {
                    $this->_output .= $child->render(true, $new_depth, $indent);
                }
                $this->_output .= "{$indent}{$this->_indent}</{$this->_nodeName}>\n";
            // Else, render child nodes first, then node value.
            } else {
                foreach ($this->_childNodes as $child) {
                    $this->_output .= $child->render(true, $new_depth, $indent);
                }
                $this->_output .= (!is_null($this->_nodeValue)) ? (str_repeat('    ', $new_depth) . "{$indent}{$this->_nodeValue}\n{$indent}{$this->_indent}</{$this->_nodeName}>\n") : "{$indent}{$this->_indent}</{$this->_nodeName}>\n";
            }
        // Else, render the child node.
        } else {
            if ((!is_null($this->_nodeValue)) || ($this->_nodeName == 'textarea')) {
                $this->_output .= ">";
                $this->_output .= "{$this->_nodeValue}</{$this->_nodeName}>\n";
            } else {
                $this->_output .= " />\n";
            }
        }

        // Return or print the rendered child node output.
        if ($ret) {
            return $this->_output;
        } else {
            print($this->_output);
        }
    }

}
