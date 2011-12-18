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
 * @package    Pop_Code
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Code;

/**
 * @category   Pop
 * @package    Pop_Code
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class ClassGenerator
{

    /**
     * Docblock generator object
     * @var Pop\Code\DocblockGenerator
     */
    protected $_docblock = null;

    /**
     * Namespace generator object
     * @var Pop\Code\NamespaceGenerator
     */
    protected $_namespace = null;

    /**
     * Class name
     * @var string
     */
    protected $_name = null;

    /**
     * Parent class that is extended
     * @var string
     */
    protected $_parent = null;

    /**
     * Interface that is implemented
     * @var string
     */
    protected $_interface = null;

    /**
     * Class abstract flag
     * @var boolean
     */
    protected $_abstract = false;

    /**
     * Array of property generator objects
     * @var array
     */
    protected $_properties = array();

    /**
     * Array of method generator objects
     * @var array
     */
    protected $_methods = array();

    /**
     * Class indent
     * @var string
     */
    protected $_indent = null;

    /**
     * Class output
     * @var string
     */
    protected $_output = null;

    /**
     * Constructor
     *
     * Instantiate the class generator object
     *
     * @param  string  $name
     * @param  string  $parent
     * @param  string  $interface
     * @param  boolean $abstract
     * @return void
     */
    public function __construct($name, $parent = null, $interface = null, $abstract = false)
    {
        $this->_name = $name;
        $this->_parent = $parent;
        $this->_interface = $interface;
        $this->_abstract = (boolean)$abstract;
    }

    /**
     * Static method to instantiate the class generator object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string  $name
     * @param  string  $parent
     * @param  string  $interface
     * @param  boolean $abstract
     * @return Pop\Code\ClassGenerator
     */
    public static function factory($name, $parent = null, $interface = null, $abstract = false)
    {
        return new self($name, $parent, $interface, $abstract);
    }

    /**
     * Set the class abstract flag
     *
     * @param  boolean $abstract
     * @return Pop\Code\ClassGenerator
     */
    public function setAbstract($abstract = false)
    {
        $this->_abstract = (boolean)$abstract;
        return $this;
    }

    /**
     * Get the class abstract flag
     *
     * @return boolean
     */
    public function isAbstract()
    {
        return $this->_abstract;
    }

    /**
     * Set the class indent
     *
     * @param  string $indent
     * @return Pop\Code\ClassGenerator
     */
    public function setIndent($indent = null)
    {
        $this->_indent = $indent;
        return $this;
    }

    /**
     * Get the class indent
     *
     * @return string
     */
    public function getIndent()
    {
        return $this->_indent;
    }

    /**
     * Set the class name
     *
     * @param  string $name
     * @return Pop\Code\ClassGenerator
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    /**
     * Get the class name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set the class parent
     *
     * @param  string $parent
     * @return Pop\Code\ClassGenerator
     */
    public function setParent($parent = null)
    {
        $this->_parent = $parent;
        return $this;
    }

    /**
     * Get the class parent
     *
     * @return string
     */
    public function getParent()
    {
        return $this->_parent;
    }

    /**
     * Set the class interface
     *
     * @param  string $interface
     * @return Pop\Code\ClassGenerator
     */
    public function setInterface($interface = null)
    {
        $this->_interface = $interface;
        return $this;
    }

    /**
     * Get the class interface
     *
     * @return string
     */
    public function getInterface()
    {
        return $this->_interface;
    }

    /**
     * Set the namespace generator object
     *
     * @param  Pop\Code\NamespaceGenerator $namespace
     * @return Pop\Code\ClassGenerator
     */
    public function setNamespace(NamespaceGenerator $namespace)
    {
        $this->_namespace = $namespace;
        return $this;
    }

    /**
     * Access the namespace generator object
     *
     * @return Pop\Code\NamespaceGenerator
     */
    public function getNamespace()
    {
        return $this->_namespace;
    }

    /**
     * Set the docblock generator object
     *
     * @param  Pop\Code\DocblockGenerator $docblock
     * @return Pop\Code\ClassGenerator
     */
    public function setDocblock(DocblockGenerator $docblock)
    {
        $this->_docblock = $docblock;
        return $this;
    }

    /**
     * Access the docblock generator object
     *
     * @return Pop\Code\DocblockGenerator
     */
    public function getDocblock()
    {
        return $this->_docblock;
    }

    /**
     * Add a class property
     *
     * @param  Pop\Code\PropertyGenerator $property
     * @return Pop\Code\ClassGenerator
     */
    public function addProperty(PropertyGenerator $property)
    {
        $this->_properties[$property->getName()] = $property;
    }

    /**
     * Get a class property
     *
     * @param  mixed $property
     * @return Pop\Code\PropertyGenerator
     */
    public function getProperty($property)
    {
        $p = ($property instanceof PropertyGenerator) ? $property->getName() : $property;
        return (isset($this->_properties[$p])) ? $this->_properties[$p] : null;
    }

    /**
     * Remove a class property
     *
     * @param  mixed $property
     * @return Pop\Code\ClassGenerator
     */
    public function removeProperty($property)
    {
        $p = ($property instanceof PropertyGenerator) ? $property->getName() : $property;
        if (isset($this->_properties[$p])) {
            unset($this->_properties[$p]);
        }
        return $this;
    }

    /**
     * Add a class method
     *
     * @param  Pop\Code\MethodGenerator $method
     * @return Pop\Code\ClassGenerator
     */
    public function addMethod(MethodGenerator $method)
    {
        $this->_methods[$method->getName()] = $method;
    }

    /**
     * Get a method property
     *
     * @param  mixed $method
     * @return Pop\Code\MethodGenerator
     */
    public function getMethod($method)
    {
        $m = ($method instanceof MethodGenerator) ? $method->getName() : $method;
        return (isset($this->_methods[$m])) ? $this->_methods[$m] : null;
    }

    /**
     * Remove a method property
     *
     * @param  mixed $method
     * @return Pop\Code\ClassGenerator
     */
    public function removeMethod($method)
    {
        $m = ($method instanceof MethodGenerator) ? $method->getName() : $method;
        if (isset($this->_methods[$m])) {
            unset($this->_methods[$m]);
        }
        return $this;
    }

    /**
     * Render method
     *
     * @param  boolean $ret
     * @return mixed
     */
    public function render($ret = false)
    {
        $abstract = ($this->_abstract) ? 'abstract ' : null;
        $this->_output = (null !== $this->_namespace) ? $this->_namespace->render(true) . PHP_EOL : null;
        $this->_output .= (null !== $this->_docblock) ? $this->_docblock->render(true) : null;
        $this->_output .= $abstract . 'class ' . $this->_name;

        if (null !== $this->_parent) {
            $this->_output .= ' extends ' . $this->_parent;
        }
        if (null !== $this->_interface) {
            $this->_output .= ' implements ' . $this->_interface;
        }

        $this->_output .= PHP_EOL . '{' . PHP_EOL;
        $this->_output .= $this->_formatProperties() . PHP_EOL;
        $this->_output .= $this->_formatMethods() . PHP_EOL;
        $this->_output .= '}' . PHP_EOL;

        if ($ret) {
            return $this->_output;
        } else {
            echo $this->_output;
        }
    }

    /**
     * Method to format the properties
     *
     * @return string
     */
    protected function _formatProperties()
    {
        $props = null;

        foreach ($this->_properties as $prop) {
            $props .= PHP_EOL . $prop->render(true);
        }

        return $props;
    }

    /**
     * Method to format the methods
     *
     * @return string
     */
    protected function _formatMethods()
    {
        $methods = null;

        foreach ($this->_methods as $method) {
            $methods .= PHP_EOL . $method->render(true);
        }

        return $methods;
    }

    /**
     * Print method
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render(true);
    }

}
