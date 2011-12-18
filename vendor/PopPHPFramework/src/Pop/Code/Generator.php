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

use Pop\File\File;

/**
 * @category   Pop
 * @package    Pop_Code
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Generator extends File
{

    /**
     * Constant to use a class
     * @var int
     */
    const FILE_CLASS = 1;

    /**
     * Constant to use an interface
     * @var int
     */
    const FILE_INTERFACE = 2;

    /**
     * Code object
     * @var Pop\Code\ClassGenerator|Pop\Code\InterfaceGenerator
     */
    protected $_code = null;

    /**
     * Docblock generator object
     * @var Pop\Code\DocblockGenerator
     */
    protected $_docblock = null;

    /**
     * Array of allowed file types.
     * @var array
     */
    protected $_allowed = array(
    	'php'    => 'text/plain',
        'php3'   => 'text/plain',
        'phtml'  => 'text/plain'
    );

    /**
     * Constructor
     *
     * Instantiate the code generator object
     *
     * @param  string $file
     * @param  array  $types
     * @return void
     */
    public function __construct($file, $type = Generator::FILE_CLASS)
    {
        parent::__construct($file);
        if ($type == self::FILE_CLASS) {
            $this->_code = new ClassGenerator($this->filename);
        } else if ($type == self::FILE_INTERFACE) {
            $this->_code = new InterfaceGenerator($this->filename);
        }
    }

    /**
     * Access the code generator object
     *
     * @return Pop\Code\ClassGenerator|Pop\Code\InterfaceGenerator
     */
    public function code()
    {
        return $this->_code;
    }

    /**
     * Set the docblock generator object
     *
     * @param  Pop\Code\DocblockGenerator $docblock
     * @return Pop\Code\Generator
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
     * Render method
     *
     * @param  boolean $ret
     * @return mixed
     */
    public function render($ret = false)
    {
        $this->_output = '<?php' . PHP_EOL;
        $this->_output .= (null !== $this->_docblock) ? $this->_docblock->render(true) . PHP_EOL : null;
        if (null !== $this->_code) {
            $this->_output .= $this->_code->render(true);
        }
        if ($ret) {
            return $this->_output;
        } else {
            echo $this->_output;
        }
    }
    /**
     * Output the code object directly.
     *
     * @param  boolean $download
     * @return Pop\Code\Generator
     */
    public function output($download = false)
    {
        $this->render(true);
        parent::output($download);
    }

    /**
     * Save the code object to disk.
     *
     * @param  string $to
     * @param  boolean $append
     * @return void
     */
    public function save($to = null, $append = false)
    {
        $this->render(true);
        parent::save($to, $append);
    }

}
