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
 * This is the Generator class of the Code component.
 *
 * @category   Pop
 * @package    Pop_Code
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.0
 */
class Generator extends File
{

    /**
     * Constant to not use a class or interface
     * @var int
     */
    const CREATE_NONE = 0;

    /**
     * Constant to use a class
     * @var int
     */
    const CREATE_CLASS = 1;

    /**
     * Constant to use an interface
     * @var int
     */
    const CREATE_INTERFACE = 2;

    /**
     * Code object
     * @var \Pop\Code\ClassGenerator|\Pop\Code\InterfaceGenerator
     */
    protected $code = null;

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
     * Code body
     * @var string
     */
    protected $body = null;

    /**
     * Code indent
     * @var string
     */
    protected $indent = null;

    /**
     * Flag to close the code file with ?>
     * @var boolean
     */
    protected $close = false;

    /**
     * Array of allowed file types.
     * @var array
     */
    protected $allowed = array(
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
     * @param  int    $type
     * @return \Pop\Code\Generator
     */
    public function __construct($file, $type = Generator::CREATE_NONE)
    {
        parent::__construct($file);
        if ($type == self::CREATE_CLASS) {
            $this->createClass();
        } else if ($type == self::CREATE_INTERFACE) {
            $this->createInterface();
        } else if (($type == self::CREATE_NONE) && file_exists($file)) {
            $this->body = str_replace('<?php', '', $this->read());
            $this->body = trim(str_replace('?>', '', $this->body)) . PHP_EOL . PHP_EOL;
        }
    }

    /**
     * Create a class generator object
     *
     * @return \Pop\Code\Generator
     */
    public function createInterface()
    {
        $this->code = new InterfaceGenerator($this->filename);
    }

    /**
     * Create a class generator object
     *
     * @return \Pop\Code\Generator
     */
    public function createClass()
    {
        $this->code = new ClassGenerator($this->filename);
    }

    /**
     * Access the code generator object
     *
     * @return \Pop\Code\ClassGenerator|\Pop\Code\InterfaceGenerator
     */
    public function code()
    {
        return $this->code;
    }

    /**
     * Set the code close flag
     *
     * @param  boolean $close
     * @return \Pop\Code\Generator
     */
    public function setClose($close = false)
    {
        $this->close = (boolean)$close;
        return $this;
    }

    /**
     * Set the code indent
     *
     * @param  string $indent
     * @return \Pop\Code\Generator
     */
    public function setIndent($indent = null)
    {
        $this->indent = $indent;
        return $this;
    }

    /**
     * Get the code indent
     *
     * @return string
     */
    public function getIndent()
    {
        return $this->indent;
    }

    /**
     * Set the namespace generator object
     *
     * @param  NamespaceGenerator $namespace
     * @return \Pop\Code\Generator
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
     * @return \Pop\Code\Generator
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
     * Set the code body
     *
     * @param  string $body
     * @param  boolean $newline
     * @return \Pop\Code\Generator
     */
    public function setBody($body, $newline = true)
    {
        $this->body = $this->indent . str_replace(PHP_EOL, PHP_EOL . $this->indent, $body);
        if ($newline) {
            $this->body .= PHP_EOL;
        }
        return $this;
    }

    /**
     * Append to the code body
     *
     * @param  string $body
     * @param  boolean $newline
     * @return \Pop\Code\Generator
     */
    public function appendToBody($body, $newline = true)
    {
        $body = str_replace(PHP_EOL, PHP_EOL . $this->indent, $body);
        $this->body .= $this->indent . $body;
        if ($newline) {
            $this->body .= PHP_EOL;
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
        return $this->body;
    }

    /**
     * Render method
     *
     * @param  boolean $ret
     * @return mixed
     */
    public function render($ret = false)
    {
        $this->output = '<?php' . PHP_EOL;
        $this->output .= (null !== $this->docblock) ? $this->docblock->render(true) . PHP_EOL : null;

        if (null !== $this->namespace) {
            $this->output .= $this->namespace->render(true) . PHP_EOL;
        }

        if (null !== $this->code) {
            $this->output .= $this->code->render(true) . PHP_EOL;
        }

        if (null !== $this->body) {
            $this->output .= PHP_EOL . $this->body . PHP_EOL . PHP_EOL;
        }

        if ($this->close) {
            $this->output .= '?>' . PHP_EOL;
        }

        if ($ret) {
            return $this->output;
        } else {
            echo $this->output;
        }
    }

    /**
     * Output the code object directly.
     *
     * @param  boolean $download
     * @return \Pop\Code\Generator
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
