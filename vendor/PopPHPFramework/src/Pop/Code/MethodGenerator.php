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
     * Method description
     * @var string
     */
    protected $_desc = null;

    /**
     * Method arguments
     * @var array
     */
    protected $_arguments = null;

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
     * Method body
     * @var string
     */
    protected $_body = null;

    /**
     * Docblock generator object
     * @var Pop\Code\DocblockGenerator
     */
    protected $_docblock = null;

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
     * Set the method description
     *
     * @param  string $desc
     * @return Pop\Code\MethodGenerator
     */
    public function setDesc($desc = null)
    {
        $this->_desc = $desc;
        return $this;
    }

    /**
     * Get the method description
     *
     * @return string
     */
    public function getDesc()
    {
        return $this->_desc;
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
        $this->_body = $body;
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
     * Set a method argument
     *
     * @return Pop\Code\MethodGenerator
     */
    public function setArgument()
    {
        return $this;
    }

    /**
     * Set method arguments
     *
     * @param array $args
     * @return Pop\Code\MethodGenerator
     */
    public function setArguments(array $args)
    {
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
     * Render method
     *
     * @param  boolean $ret
     * @return mixed
     */
    public function render($ret = false)
    {
        $static = ($this->_static) ? ' static' : null;
        $args = null;

        $this->_docblock = new DocblockGenerator($this->_desc, $this->_indent);

        $this->_output = $this->_docblock->render(true);
        $this->_output .= $this->_indent . $this->_visibility . $static . ' function ' . $this->_name . '(' . $args . ')' . PHP_EOL;
        $this->_output .= $this->_indent . '{' . PHP_EOL;
        $this->_output .= $this->_body . PHP_EOL;
        $this->_output .= $this->_indent . '}' . PHP_EOL;

        if ($ret) {
            return $this->_output;
        } else {
            echo $this->_output;
        }
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
