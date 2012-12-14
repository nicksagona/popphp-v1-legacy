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
 * This is the Namespace class for the Code component.
 *
 * @category   Pop
 * @package    Pop_Code
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.0
 */
class NamespaceGenerator
{

    /**
     * Namespace
     * @var string
     */
    protected $namespace = null;

    /**
     * Array of namespaces to use
     * @var array
     */
    protected $use = array();

    /**
     * Docblock generator object
     * @var \Pop\Code\DocblockGenerator
     */
    protected $docblock = null;

    /**
     * Namespace indent
     * @var string
     */
    protected $indent = null;

    /**
     * Namespace output
     * @var string
     */
    protected $output = null;

    /**
     * Constructor
     *
     * Instantiate the property generator object
     *
     * @param  string $namespace
     * @return \Pop\Code\NamespaceGenerator
     */

    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * Static method to instantiate the property generator object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $namespace
     * @return \Pop\Code\NamespaceGenerator
     */
    public static function factory($namespace)
    {
        return new self($namespace);
    }

    /**
     * Set the namespace
     *
     * @param  string $namespace
     * @return \Pop\Code\NamespaceGenerator
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Get the namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set a namespace to use
     *
     * @param  string $use
     * @param  string $as
     * @return \Pop\Code\NamespaceGenerator
     */
    public function setUse($use, $as = null)
    {
        $this->use[$use] = $as;
        return $this;
    }

    /**
     * Set namespaces to use
     *
     * @param  array $uses
     * @return \Pop\Code\NamespaceGenerator
     */
    public function setUses(array $uses)
    {
        foreach ($uses as $use) {
            if (is_array($use)) {
                $this->use[$use[0]] = (isset($use[1])) ? $use[1] : null;
            } else {
                $this->use[$use] = null;
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
        $this->docblock = new DocblockGenerator(null, $this->indent);
        $this->docblock->setTag('namespace');
        $this->output = $this->docblock->render(true);
        $this->output .= $this->indent . 'namespace ' . $this->namespace . ';' . PHP_EOL;

        if (count($this->use) > 0) {
            $this->output .= PHP_EOL . $this->indent . 'use ';
            $i = 0;
            foreach ($this->use as $ns => $as) {
                if ($i == 0) {
                    $this->output .= $ns;
                    if (null !== $as) {
                        $this->output .= ' as ' . $as;
                    }
                } else {
                    $this->output .= $this->indent . '    '. $ns;
                    if (null !== $as) {
                        $this->output .= ' as ' . $as;
                    }
                }
                $i++;
                if ($i < count($this->use)) {
                    $this->output .= ',' . PHP_EOL;
                } else {
                    $this->output .= ';' . PHP_EOL;
                }
            }
        }

        if ($ret) {
            return $this->output;
        } else {
            echo $this->output;
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
