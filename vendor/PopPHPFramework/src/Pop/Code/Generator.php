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
     * Class generator object
     * @var Pop\Code\ClassGenerator
     */
    protected $_class = null;

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
    public function __construct($file)
    {
        parent::__construct($file);
    }

    /**
     * Set the class generator object
     *
     * @param  Pop\Code\ClassGenerator $class
     * @return Pop\Code\Generator
     */
    public function setClass(ClassGenerator $class)
    {
        $this->_class = $class;
        return $this;
    }

    /**
     * Access the class generator object
     *
     * @return Pop\Code\ClassGenerator
     */
    public function getClass()
    {
        return $this->_class;
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

}
