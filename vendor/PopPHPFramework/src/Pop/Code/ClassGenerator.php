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
class ClassGenerator
{

    /**
     * Class body
     * @var string
     */
    protected $_body = null;

    /**
     * Docblock generator object
     * @var Pop\Code\DocblockGenerator
     */
    protected $_docblock = null;

    /**
     * Namespace generator object
     * @var array
     */
    protected $_namespace = null;

    /**
     * Array of property generator objects
     * @var array
     */
    protected $_properties = array();

    /**
     * Array of method generator objects
     * @var array
     */
    protected $_methods = array();

    /**
     * Set the class body
     *
     * @param  string $body
     * @return Pop\Code\ClassGenerator
     */
    public function setBody($body)
    {
        $this->_body = $body;
        return $this;
    }

    /**
     * Get the class body
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

}
