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
class NamespaceGenerator
{

    /**
     * Namespace
     * @var string
     */
    protected $_namespace = null;

    /**
     * Array of namespaces to use
     * @var array
     */
    protected $_use = array();

    /**
     * Docblock generator object
     * @var Pop\Code\DocblockGenerator
     */
    protected $_docblock = null;

    /**
     * Namespace indent
     * @var string
     */
    protected $_indent = null;

    /**
     * Namespace output
     * @var string
     */
    protected $_output = null;

    /**
     * Constructor
     *
     * Instantiate the property generator object
     *
     * @param  string $namespace
     * @return void
     */

    public function __construct($namespace)
    {
        $this->_namespace = $namespace;
    }

    /**
     * Static method to instantiate the property generator object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $namespace
     * @return Pop\Code\NamespaceGenerator
     */
    public static function factory($namespace)
    {
        return new self($namespace);
    }

    /**
     * Set the namespace
     *
     * @param  string $namespace
     * @return Pop\Code\NamespaceGenerator
     */
    public function setNamespace($namespace)
    {
        $this->_namespace = $namespace;
        return $this;
    }

    /**
     * Get the namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->_namespace;
    }

    /**
     * Set a namespace to use
     *
     * @param  string $use
     * @param  string $as
     * @return Pop\Code\NamespaceGenerator
     */
    public function setUse($use, $as = null)
    {
        $this->_use[$use] = $as;
        return $this;
    }

    /**
     * Set namespaces to use
     *
     * @param  array $uses
     * @return Pop\Code\NamespaceGenerator
     */
    public function setUses(array $uses)
    {
        foreach ($uses as $use) {
            if (is_array($use)) {
                $this->_use[$use[0]] = (isset($use[1])) ? $use[1] : null;
            } else {
                $this->_use[$use] = null;
            }
        }
        return $this;
    }
        /**
     * Render property
     *
     * @param  boolean $ret
     * @return mixed
     */
    public function render($ret = false)
    {
        $this->_docblock = new DocblockGenerator(null, $this->_indent);
        $this->_docblock->setTag('namespace');
        $this->_output = $this->_docblock->render(true);
        $this->_output .= $this->_indent . 'namespace ' . $this->_namespace . ';' . PHP_EOL;

        if (count($this->_use) > 0) {
            $this->_output .= PHP_EOL . $this->_indent . 'use ';
            $i = 0;
            foreach ($this->_use as $ns => $as) {
                if ($i == 0) {
                    $this->_output .= $ns;
                    if (null !== $as) {
                        $this->_output .= ' as ' . $as;
                    }
                } else {
                    $this->_output .= $this->_indent . '    '. $ns;
                    if (null !== $as) {
                        $this->_output .= ' as ' . $as;
                    }
                }
                $i++;
                if ($i < count($this->_use)) {
                    $this->_output .= ',' . PHP_EOL;
                } else {
                    $this->_output .= ';' . PHP_EOL;
                }
            }
        }

        if ($ret) {
            return $this->_output;
        } else {
            echo $this->_output;
        }
    }

    /**
     * Print namespace
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render(true);
    }

}
