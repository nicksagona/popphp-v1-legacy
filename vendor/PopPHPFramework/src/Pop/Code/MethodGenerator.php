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

use Pop\Code\DocblockGenerator;

/**
 * @category   Pop
 * @package    Pop_Code
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class MethodGenerator
{

    /**
     * Docblock generator object
     * @var Pop\Code\DocblockGenerator
     */
    protected $_docblock = null;

    /**
     * Method arguments
     * @var array
     */
    protected $_arguments = array();

    /**
     * Method name
     * @var string
     */
    protected $_name = null;

    /**
     * Method visibility
     * @var string
     */
    protected $_visibility = 'public';

    /**
     * Method static flag
     * @var boolean
     */
    protected $_static = false;

    /**
     * Method abstract flag
     * @var boolean
     */
    protected $_abstract = false;

    /**
     * Method final flag
     * @var boolean
     */
    protected $_final = false;

    /**
     * Method interface flag
     * @var boolean
     */
    protected $_interface = false;

    /**
     * Method body
     * @var string
     */
    protected $_body = null;

    /**
     * Method indent
     * @var string
     */
    protected $_indent = '    ';

    /**
     * Method output
     * @var string
     */
    protected $_output = null;

    /**
     * Constructor
     *
     * Instantiate the method generator object
     *
     * @param  string  $name
     * @param  string  $visibility
     * @param  boolean $static
     * @return void
     */
    public function __construct($name, $visibility = 'public', $static = false)
    {
        $this->_name = $name;
        $this->_visibility = $visibility;
        $this->_static = (boolean)$static;
    }

    /**
     * Static method to instantiate the method generator object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string  $name
     * @param  string  $visibility
     * @param  boolean $static
     * @return Pop\Code\MethodGenerator
     */
    public static function factory($name, $visibility = 'public', $static = false)
    {
        return new self($name, $visibility, $static);
    }

    /**
     * Set the method static flag
     *
     * @param  boolean $static
     * @return Pop\Code\MethodGenerator
     */
    public function setStatic($static = false)
    {
        $this->_static = (boolean)$static;
        return $this;
    }

    /**
     * Get the method static flag
     *
     * @return boolean
     */
    public function isStatic()
    {
        return $this->_static;
    }

    /**
     * Set the method abstract flag
     *
     * @param  boolean $abstract
     * @return Pop\Code\MethodGenerator
     */
    public function setAbstract($abstract = false)
    {
        $this->_abstract = (boolean)$abstract;
        return $this;
    }

    /**
     * Get the method abstract flag
     *
     * @return boolean
     */
    public function isAbstract()
    {
        return $this->_abstract;
    }

    /**
     * Set the method final flag
     *
     * @param  boolean $final
     * @return Pop\Code\MethodGenerator
     */
    public function setFinal($final = false)
    {
        $this->_final = (boolean)$final;
        return $this;
    }

    /**
     * Get the method final flag
     *
     * @return boolean
     */
    public function isFinal()
    {
        return $this->_final;
    }

    /**
     * Set the method interface flag
     *
     * @param  boolean $interface
     * @return Pop\Code\MethodGenerator
     */
    public function setInterface($interface = false)
    {
        $this->_interface = (boolean)$interface;
        return $this;
    }

    /**
     * Get the method interface flag
     *
     * @return boolean
     */
    public function isInterface()
    {
        return $this->_interface;
    }

    /**
     * Set the method description
     *
     * @param  string $desc
     * @return Pop\Code\MethodGenerator
     */
    public function setDesc($desc = null)
    {
        if (null !== $this->_docblock) {
            $this->_docblock->setDesc($desc);
        } else {
            $this->_docblock = new DocblockGenerator($desc, $this->_indent);
        }
        return $this;
    }

    /**
     * Get the method description
     *
     * @return string
     */
    public function getDesc()
    {
        $desc = null;
        if (null !== $this->_docblock) {
            $desc = $this->_docblock->getDesc();
        }
        return $desc;
    }

    /**
     * Set the method indent
     *
     * @param  string $indent
     * @return Pop\Code\MethodGenerator
     */
    public function setIndent($indent = null)
    {
        $this->_indent = $indent;
        return $this;
    }

    /**
     * Get the method indent
     *
     * @return string
     */
    public function getIndent()
    {
        return $this->_indent;
    }

    /**
     * Set the method name
     *
     * @param  string $name
     * @return Pop\Code\MethodGenerator
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    /**
     * Get the method name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set the method body
     *
     * @param  string $body
     * @return Pop\Code\MethodGenerator
     */
    public function setBody($body)
    {
        $this->_body = $this->_indent . '    ' .  str_replace(PHP_EOL, PHP_EOL . $this->_indent . '    ', $body);
        return $this;
    }

    /**
     * Append to the method body
     *
     * @param  string  $body
     * @param  boolean $newline
     * @return Pop\Code\MethodGenerator
     */
    public function appendToBody($body, $newline = true)
    {
        $body = str_replace(PHP_EOL, PHP_EOL . $this->_indent . '    ', $body);
        $this->_body .= $this->_indent . '    ' . $body;
        if ($newline) {
            $this->_body .= PHP_EOL;
        }
        return $this;
    }

    /**
     * Get the method body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->_body;
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
     * Set the method visibility
     *
     * @param  string $visibility
     * @return Pop\Code\MethodGenerator
     */
    public function setVisibility($visibility = 'public')
    {
        $this->_visibility = $visibility;
        return $this;
    }

    /**
     * Get the method visibility
     *
     * @return string
     */
    public function getVisibility()
    {
        return $this->_visibility;
    }

    /**
     * Add a method argument
     *
     * @param string  $name
     * @param mixed   $value
     * @param string  $type
     * @return Pop\Code\MethodGenerator
     */
    public function addArgument($name, $value = null, $type = null)
    {
        $typeHintsNotAllowed = array(
            'int',
            'integer',
            'boolean',
            'float',
            'string'
        );
        $argType = (!in_array($type, $typeHintsNotAllowed)) ? $type : null;
        $this->_arguments[$name] = array('value' => $value, 'type' => $argType);
        if (null === $this->_docblock) {
            $this->_docblock = new DocblockGenerator(null, $this->_indent);
        }
        if (null !== $type) {
            if (substr($name, 0, 1) != '$') {
                $name = '$' . $name;
            }
            $this->_docblock->setParam($type, $name);
        }
        return $this;
    }

    /**
     * Add method arguments
     *
     * @param array $args
     * @return Pop\Code\MethodGenerator
     */
    public function addArguments(array $args)
    {
        foreach ($args as $arg) {
            $value = (isset($arg['value'])) ? $arg['value'] : null;
            $type = (isset($arg['type'])) ? $arg['type'] : null;
            $this->addArgument($arg['name'], $value, $type);
        }
        return $this;
    }

    /**
     * Add a method argument (synonym method for convenience)
     *
     * @param string  $name
     * @param mixed   $value
     * @param string  $type
     * @return Pop\Code\MethodGenerator
     */
    public function addParameter($name, $value = null, $type = null)
    {
        $this->addArgument($name, $value, $type);
        return $this;
    }

    /**
     * Add method arguments (synonym method for convenience)
     *
     * @param array $args
     * @return Pop\Code\MethodGenerator
     */
    public function addParameters(array $args)
    {
        $this->addArguments($args);
        return $this;
    }

    /**
     * Get a method argument
     *
     * @return array
     */
    public function getArgument($name)
    {
        return (isset($this->_arguments[$name])) ? $this->_arguments[$name] : null;
    }

    /**
     * Get the method arguments
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->_arguments;
    }

    /**
     * Get a method argument (synonym method for convenience)
     *
     * @return array
     */
    public function getParameter($name)
    {
        return (isset($this->_arguments[$name])) ? $this->_arguments[$name] : null;
    }

    /**
     * Get the method arguments (synonym method for convenience)
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->_arguments;
    }

    /**
     * Render method
     *
     * @param  boolean $ret
     * @return mixed
     */
    public function render($ret = false)
    {
        $final = ($this->_final) ? 'final ' : null;
        $abstract = ($this->_abstract) ? 'abstract ' : null;
        $static = ($this->_static) ? ' static' : null;
        $args = $this->_formatArguments();

        $this->_output = PHP_EOL . (null !== $this->_docblock) ? $this->_output = $this->_docblock->render(true) : null;
        $this->_output .= $this->_indent . $final . $abstract . $this->_visibility .
           $static . ' function ' . $this->_name . '(' . $args . ')';

        if ((!$this->_abstract) && (!$this->_interface)) {
            $this->_output .= PHP_EOL . $this->_indent . '{' . PHP_EOL;
            $this->_output .= $this->_body. PHP_EOL;
            $this->_output .= $this->_indent . '}';
        } else {
            $this->_output .= ';';
        }

        $this->_output .= PHP_EOL;

        if ($ret) {
            return $this->_output;
        } else {
            echo $this->_output;
        }
    }

    /**
     * Method to format the arguments
     *
     * @return string
     */
    protected function _formatArguments()
    {
        $args = null;

        $i = 0;
        foreach ($this->_arguments as $name => $arg) {
            $i++;
            $args .= (null !== $arg['type']) ? $arg['type'] . ' ' : null;
            $args .= (substr($name, 0, 1) != '$') ? "\$" . $name : $name;
            $args .= (null !== $arg['value']) ? " = " . $arg['value'] : null;
            if ($i < count($this->_arguments)) {
                $args .= ', ';
            }
        }

        return $args;
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
