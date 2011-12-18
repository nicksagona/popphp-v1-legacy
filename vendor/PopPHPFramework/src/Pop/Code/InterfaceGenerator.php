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
class InterfaceGenerator
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
     * Parent interface that is extended
     * @var string
     */
    protected $_parent = null;

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
     * Instantiate the interface generator object
     *
     * @param  string  $name
     * @param  string  $parent
     * @return void
     */
    public function __construct($name, $parent = null)
    {
        $this->_name = $name;
        $this->_parent = $parent;
    }

    /**
     * Static method to instantiate the interface generator object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string  $name
     * @param  string  $parent
     * @return Pop\Code\InterfaceGenerator
     */
    public static function factory($name, $parent = null)
    {
        return new self($name, $parent);
    }

    /**
     * Set the interface indent
     *
     * @param  string $indent
     * @return Pop\Code\InterfaceGenerator
     */
    public function setIndent($indent = null)
    {
        $this->_indent = $indent;
        return $this;
    }

    /**
     * Get the interface indent
     *
     * @return string
     */
    public function getIndent()
    {
        return $this->_indent;
    }

    /**
     * Set the interface parent
     *
     * @param  string $parent
     * @return Pop\Code\InterfaceGenerator
     */
    public function setParent($parent = null)
    {
        $this->_parent = $parent;
        return $this;
    }

    /**
     * Get the interface parent
     *
     * @return string
     */
    public function getParent()
    {
        return $this->_parent;
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
        $this->_output = (null !== $this->_namespace) ? $this->_namespace->render(true) . PHP_EOL : null;
        $this->_output .= (null !== $this->_docblock) ? $this->_docblock->render(true) : null;
        $this->_output .= 'interface ' . $this->_name;

        if (null !== $this->_parent) {
            $this->_output .= ' extends ' . $this->_parent;
        }

        $this->_output .= PHP_EOL . '{' . PHP_EOL;
        $this->_output .= $this->_formatMethods() . PHP_EOL;
        $this->_output .= '}' . PHP_EOL;

        if ($ret) {
            return $this->_output;
        } else {
            echo $this->_output;
        }
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
            $method->setInterface(true);
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
