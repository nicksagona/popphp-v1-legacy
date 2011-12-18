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
class Reflection extends \ReflectionClass
{

    /**
     * Code to reflect
     * @var string
     */
    protected $_code = null;

    /**
     * Code generator object
     * @var Pop\Code\Generator
     */
    protected $_generator = null;

    /**
     * Constructor
     *
     * Instantiate the code reflection object
     *
     * @param  string  $code
     * @return void
     */
    public function __construct($code)
    {
        $this->_code = $code;
        parent::__construct($code);
        $this->_buildGenerator();
    }

    /**
     * Static method to instantiate the code reflection object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string  $code
     * @return Pop\Code\Reflection
     */
    public static function factory($code)
    {
        return new self($code);
    }

    /**
     * Get the code string
     *
     * @return string
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Get the code generator
     *
     * @return Pop\Code\Generator
     */
    public function getGenerator()
    {
        return $this->_generator;
    }

    /**
     * Build the code generator based the reflection class
     *
     * @return void
     */
    protected function _buildGenerator()
    {
        // Create generator object
        $type = ($this->isInterface()) ? Generator::CREATE_INTERFACE : Generator::CREATE_CLASS;
        $this->_generator = new Generator($this->getShortName() . '.php', $type);

        // Detect and set namespace
        if ($this->inNamespace()) {
            $this->_generator->setNamespace(new NamespaceGenerator($this->getNamespaceName()));
        }

        // Detect and set if the class is abstract
        if ($this->isAbstract()) {
            $this->_generator->code()->setAbstract(true);
        }

        // Detect and set if the class is a child class
        $parent = $this->getParentClass();
        if ($parent !== false) {
            if ($parent->inNamespace()) {
                $this->_generator->getNamespace()->setUse($parent->getNamespaceName() . '\\' . $parent->getShortName());
            }
            $this->_generator->code()->setParent($parent->getShortName());
        }

        // Detect and set if the class implements any interfaces
        $interfaces = $this->getInterfaces();
        if ($interfaces !== false) {
            $interfacesAry = array();
            foreach ($interfaces as $interface) {
                if ($interface->inNamespace()) {
                    $this->_generator->getNamespace()->setUse($interface->getNamespaceName() . '\\' . $interface->getShortName());
                }
                $interfacesAry[] = $interface->getShortName();
            }
            $this->_generator->code()->setInterface(implode(', ', $interfacesAry));
        }

        // Detect and set constants
        $constants = $this->getConstants();
        if (count($constants) > 0) {
            foreach ($constants as $key => $value) {
                $this->_generator->code()->addProperty(new PropertyGenerator($key, gettype($value), $value, 'const'));
            }
        }

        // Detect and set properties
        $properties = $this->getDefaultProperties();
        if (count($properties) > 0) {
            //print_r($properties);
            //foreach ($properties as $property) {
            //    //$property->setAccessible(true);
            //    if ($property->isPublic()) {
            //        $visibility = 'public';
            //    } else if ($property->isProtected()) {
            //        $visibility = 'protected';
            //    } else if ($property->isPrivate()) {
            //        $visibility = 'private';
            //    }
            //    $class = $this->getName();
            //    $prop = new PropertyGenerator($property->getName(), gettype($property->getValue()), $property->getValue(), $visibility);
            //    $prop->setStatic($property->isStatic());
            //    $this->_generator->code()->addProperty($prop);
            //}
        }

        //$this->_generator->output();
    }

}
