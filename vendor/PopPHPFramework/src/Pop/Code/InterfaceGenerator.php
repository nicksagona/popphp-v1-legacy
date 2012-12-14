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
 * This is the Interface class of the Code component.
 *
 * @category   Pop
 * @package    Pop_Code
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.0
 */
class InterfaceGenerator
{

    /**
     * Docblock generator object
     * @var \Pop\Code\DocblockGenerator
     */
    protected $docblock = null;

    /**
     * Namespace generator object
     * @var \Pop\Code\NamespaceGenerator
     */
    protected $namespace = null;

    /**
     * Class name
     * @var string
     */
    protected $name = null;

    /**
     * Parent interface that is extended
     * @var string
     */
    protected $parent = null;

    /**
     * Array of method generator objects
     * @var array
     */
    protected $methods = array();

    /**
     * Class indent
     * @var string
     */
    protected $indent = null;

    /**
     * Class output
     * @var string
     */
    protected $output = null;

    /**
     * Constructor
     *
     * Instantiate the interface generator object
     *
     * @param  string  $name
     * @param  string  $parent
     * @return \Pop\Code\InterfaceGenerator
     */
    public function __construct($name, $parent = null)
    {
        $this->name = $name;
        $this->parent = $parent;
    }
    /**
     * Static method to instantiate the interface generator object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string  $name
     * @param  string  $parent
     * @return \Pop\Code\InterfaceGenerator
     */
    public static function factory($name, $parent = null)
    {
        return new self($name, $parent);
    }

    /**
     * Set the interface indent
     *
     * @param  string $indent
     * @return \Pop\Code\InterfaceGenerator
     */
    public function setIndent($indent = null)
    {
        $this->indent = $indent;
        return $this;
    }

    /**
     * Get the interface indent
     *
     * @return string
     */
    public function getIndent()
    {
        return $this->indent;
    }

    /**
     * Set the interface name
     *
     * @param  string $name
     * @return \Pop\Code\InterfaceGenerator
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the interface name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the interface parent
     *
     * @param  string $parent
     * @return \Pop\Code\InterfaceGenerator
     */
    public function setParent($parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Get the interface parent
     *
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the namespace generator object
     *
     * @param  NamespaceGenerator $namespace
     * @return \Pop\Code\ClassGenerator
     */
    public function setNamespace(NamespaceGenerator $namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Access the namespace generator object
     *
     * @return \Pop\Code\NamespaceGenerator
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set the docblock generator object
     *
     * @param  DocblockGenerator $docblock
     * @return \Pop\Code\ClassGenerator
     */
    public function setDocblock(DocblockGenerator $docblock)
    {
        $this->docblock = $docblock;
        return $this;
    }

    /**
     * Access the docblock generator object
     *
     * @return \Pop\Code\DocblockGenerator
     */
    public function getDocblock()
    {
        return $this->docblock;
    }

    /**
     * Add a class method
     *
     * @param  MethodGenerator $method
     * @return \Pop\Code\ClassGenerator
     */
    public function addMethod(MethodGenerator $method)
    {
        $this->methods[$method->getName()] = $method;
        return $this;
    }

    /**
     * Get a method property
     *
     * @param  mixed $method
     * @return /Pop\Code\MethodGenerator
     */
    public function getMethod($method)
    {
        $m = ($method instanceof MethodGenerator) ? $method->getName() : $method;
        return (isset($this->methods[$m])) ? $this->methods[$m] : null;
    }

    /**
     * Remove a method property
     *
     * @param  mixed $method
     * @return \Pop\Code\ClassGenerator
     */
    public function removeMethod($method)
    {
        $m = ($method instanceof MethodGenerator) ? $method->getName() : $method;
        if (isset($this->methods[$m])) {
            unset($this->methods[$m]);
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
        $this->output = (null !== $this->namespace) ? $this->namespace->render(true) . PHP_EOL : null;
        $this->output .= (null !== $this->docblock) ? $this->docblock->render(true) : null;
        $this->output .= 'interface ' . $this->name;

        if (null !== $this->parent) {
            $this->output .= ' extends ' . $this->parent;
        }

        $this->output .= PHP_EOL . '{' . PHP_EOL;
        $this->output .= $this->formatMethods() . PHP_EOL;
        $this->output .= '}' . PHP_EOL;

        if ($ret) {
            return $this->output;
        } else {
            echo $this->output;
        }
    }

    /**
     * Method to format the methods
     *
     * @return string
     */
    protected function formatMethods()
    {
        $methods = null;

        foreach ($this->methods as $method) {
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
