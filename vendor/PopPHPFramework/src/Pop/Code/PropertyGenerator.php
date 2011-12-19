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
class PropertyGenerator
{

    /**
     * Docblock generator object
     * @var Pop\Code\DocblockGenerator
     */
    protected $_docblock = null;

    /**
     * Property type
     * @var string
     */
    protected $_type = null;

    /**
     * Property name
     * @var string
     */
    protected $_name = null;

    /**
     * Property visibility
     * @var string
     */
    protected $_visibility = 'public';

    /**
     * Property static flag
     * @var boolean
     */
    protected $_static = false;

    /**
     * Property value
     * @var mixed
     */
    protected $_value = null;

    /**
     * Property indent
     * @var string
     */
    protected $_indent = '    ';

    /**
     * Property output
     * @var string
     */
    protected $_output = null;

    /**
     * Constructor
     *
     * Instantiate the property generator object
     *
     * @param  string $name
     * @param  string $type
     * @param  mixed  $value
     * @param  string $visibility
     * @return void
     */
    public function __construct($name, $type, $value = null, $visibility = 'public')
    {
        $this->_type = $type;
        $this->_name = $name;
        $this->_value = $value;
        $this->_visibility = $visibility;
    }

    /**
     * Static method to instantiate the property generator object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $name
     * @param  string $type
     * @param  mixed  $value
     * @param  string $visibility
     * @return Pop\Code\PropertyGenerator
     */
    public static function factory($name, $type, $value = null, $visibility = 'public')
    {
        return new self($name, $type, $value, $visibility);
    }

    /**
     * Set the property static flag
     *
     * @param  boolean $static
     * @return Pop\Code\PropertyGenerator
     */
    public function setStatic($static = false)
    {
        $this->_static = (boolean)$static;
        return $this;
    }

    /**
     * Get the property static flag
     *
     * @return boolean
     */
    public function isStatic()
    {
        return $this->_static;
    }

    /**
     * Set the property description
     *
     * @param  string $desc
     * @return Pop\Code\PropertyGenerator
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
     * Get the property description
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
     * Set the property indent
     *
     * @param  string $indent
     * @return Pop\Code\PropertyGenerator
     */
    public function setIndent($indent = null)
    {
        $this->_indent = $indent;
        return $this;
    }

    /**
     * Get the property indent
     *
     * @return string
     */
    public function getIndent()
    {
        return $this->_indent;
    }

    /**
     * Set the property type
     *
     * @param  string $type
     * @return Pop\Code\PropertyGenerator
     */
    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }

    /**
     * Get the property type
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Set the property name
     *
     * @param  string $name
     * @return Pop\Code\PropertyGenerator
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    /**
     * Get the property name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set the property value
     *
     * @param  mixed $value
     * @return Pop\Code\PropertyGenerator
     */
    public function setValue($value = null)
    {
        $this->_value = $value;
        return $this;
    }

    /**
     * Get the property value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * Set the property visibility
     *
     * @param  string $visibility
     * @return Pop\Code\PropertyGenerator
     */
    public function setVisibility($visibility = 'public')
    {
        $this->_visibility = $visibility;
        return $this;
    }

    /**
     * Get the property visibility
     *
     * @return string
     */
    public function getVisibility()
    {
        return $this->_visibility;
    }

    /**
     * Set the docblock generator object
     *
     * @param  Pop\Code\DocblockGenerator $docblock
     * @return Pop\Code\PropertyGenerator
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
     * Render property
     *
     * @param  boolean $ret
     * @return mixed
     */
    public function render($ret = false)
    {
        $static = null;
        if ($this->_visibility != 'const') {
            $varDeclaration = ' $';
            if ($this->_static) {
                $static = ' static';
            }
        } else {
            $varDeclaration = ' ';
        }

        if (null === $this->_docblock) {
            $this->_docblock = new DocblockGenerator(null, $this->_indent);
        }
        $this->_docblock->setTag('var', $this->_type);
        $this->_output = $this->_docblock->render(true);
        $this->_output .= $this->_indent . $this->_visibility . $static . $varDeclaration . $this->_name;

        if (null !== $this->_value) {
            if ($this->_type == 'array') {
                $val = (count($this->_value) == 0) ? 'array()' : $this->_formatArrayValues();
                $this->_output .= ' = ' . $val . PHP_EOL;
            } else if (($this->_type == 'int') || ($this->_type == 'float')) {
                $this->_output .= ' = ' . $this->_value . ';';
            } else if ($this->_type == 'boolean') {
                $val = ($this->_value) ? 'true' : 'false';
                $this->_output .= " = " . $val . ";";
            } else {
                $this->_output .= " = '" . $this->_value . "';";
            }
        } else {
            $val = ($this->_type == 'array') ? 'array()' : 'null';
            $this->_output .= ' = ' . $val . ';';
        }

        $this->_output .= PHP_EOL;

        if ($ret) {
            return $this->_output;
        } else {
            echo $this->_output;
        }
    }

    /**
     * Format array value
     *
     * @return string
     */
    protected function _formatArrayValues()
    {
        $ary = str_replace(PHP_EOL, PHP_EOL . $this->_indent . '  ', var_export($this->_value, true));
        $ary .= ';';
        $ary = str_replace('  );', ');', $ary);
        $ary = str_replace('NULL', 'null', $ary);

        return $ary;
    }

    /**
     * Get the longest key length
     *
     * @return int
     */
    protected function _getKeyLength()
    {
        $length = 0;
        $keys = array_keys($this->_value);

        foreach ($keys as $key => $value) {
            if (strlen($key) > $length) {
                $length = strlen($key);
            }
        }

        return $length;
    }

    /**
     * Print property
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render(true);
    }

}
