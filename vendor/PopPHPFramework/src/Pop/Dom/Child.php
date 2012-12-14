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
 * This is the Child class for the Dom component.
 *
 * @category   Pop
 * @package    Pop_Dom
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.0
 */
class Child extends AbstractDom
{

    /**
     * Child element node name
     * @var string
     */
    protected $nodeName = null;

    /**
     * Child element node value
     * @var string
     */
    protected $nodeValue = null;

    /**
     * Flag to render children before node value or not.
     * @var boolean
     */
    protected $childrenFirst = false;

    /**
     * Child element attributes
     * @var array
     */
    protected $attributes = array();

    /**
     * Constructor
     *
     * Instantiate the form element object
     *
     * @param  string $name
     * @param  string $value
     * @param  mixed  $childNode
     * @param  boolean $first
     * @param  string $indent
     * @return \Pop\Dom\Child
     */
    public function __construct($name, $value = null, $childNode = null, $first = false, $indent = null)
    {
        $this->nodeName = strtolower($name);
        $this->nodeValue = $value;
        $this->childrenFirst = $first;

        if (null !== $childNode) {
            $this->addChild($childNode);
        }

        $this->indent = $indent;
    }

    /**
     * Static factory method to create child objects
     *
     * @param  array $c
     * @return \Pop\Dom\Child
     */
    public static function factory(array $c)
    {
        $nodeName = $c['nodeName'];
        $nodeValue = (isset($c['nodeValue']) ? $c['nodeValue'] : null);
        $childFirst = (isset($c['childrenFirst']) ? $c['childrenFirst'] : false);
        $indent = (isset($c['indent']) ? $c['indent'] : null);

        $child = new static($nodeName, $nodeValue, null, $childFirst, $indent);
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
     * @return string
     */
    public function getNodeName()
    {
        return $this->nodeName;
    }

    /**
     * Method to return the child node value.
     *
     * @return string
     */
    public function getNodeValue()
    {
        return $this->nodeValue;
    }

    /**
     * Method to set the child node name.
     *
     * @param  string $name
     * @return \Pop\Dom\Child
     */
    public function setNodeName($name)
    {
        $this->nodeName = strtolower($name);
        return $this;
    }

    /**
     * Method to set the child node value.
     *
     * @param  string $value
     * @return \Pop\Dom\Child
     */
    public function setNodeValue($value)
    {
        $this->nodeValue = $value;
        return $this;
    }

    /**
     * Set an attribute or attributes for the child element object.
     *
     * @param  array|string $a
     * @param  string $v
     * @return \Pop\Dom\Child
     */
    public function setAttributes($a, $v = null)
    {
        if (is_array($a)) {
            foreach ($a as $name => $value) {
                $this->attributes[strtolower($name)] = $value;
            }
        } else {
            $this->attributes[strtolower($a)] = $v;
        }
        return $this;
    }

    /**
     * Get the attribute of the child object.
     *
     * @param  string $name
     * @return string
     */
    public function getAttribute($name)
    {
        return (isset($this->attributes[$name])) ? $this->attributes[$name] : null;
    }

    /**
     * Get the attributes of the child object.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
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
        $this->output = '';
        $this->indent = (null === $this->indent) ? str_repeat('    ', $depth) : $this->indent;
        $attribs = '';
        $attribAry = array();

        // Format child attributes, if applicable.
        if (count($this->attributes) > 0) {
            foreach ($this->attributes as $key => $value) {
                $attribAry[] = $key . "=\"" . $value . "\"";
            }
            $attribs = ' ' . implode(' ', $attribAry);
        }

        // Initialize the node.
        $this->output .= "{$indent}{$this->indent}<{$this->nodeName}{$attribs}";

        if ((null === $indent) && (null !== $this->indent)) {
            $indent = $this->indent;
            $origIndent = $this->indent;
        } else {
            $origIndent = $indent . $this->indent;
        }

        // If current child element has child nodes, format and render.
        if (count($this->childNodes) > 0) {
            $this->output .= ">\n";
            $new_depth = $depth + 1;

            // Render node value before the child nodes.
            if (!$this->childrenFirst) {
                $this->output .= (null !== $this->nodeValue) ? (str_repeat('    ', $new_depth) . "{$indent}{$this->nodeValue}\n") : '';
                foreach ($this->childNodes as $child) {
                    $this->output .= $child->render(true, $new_depth, $indent);
                }
                $this->output .= "{$origIndent}</{$this->nodeName}>\n";
            // Else, render child nodes first, then node value.
            } else {
                foreach ($this->childNodes as $child) {
                    $this->output .= $child->render(true, $new_depth, $indent);
                }
                $this->output .= (null !== $this->nodeValue) ? (str_repeat('    ', $new_depth) . "{$indent}{$this->nodeValue}\n{$origIndent}</{$this->nodeName}>\n") : "{$origIndent}</{$this->nodeName}>\n";
            }

            // Else, render the child node.
        } else {
            if ((null !== $this->nodeValue) || ($this->nodeName == 'textarea')) {
                $this->output .= ">";
                $this->output .= "{$this->nodeValue}</{$this->nodeName}>\n";
            } else {
                $this->output .= " />\n";
            }
        }

        // Return or print the rendered child node output.
        if ($ret) {
            return $this->output;
        } else {
            echo $this->output;
        }
    }

}
