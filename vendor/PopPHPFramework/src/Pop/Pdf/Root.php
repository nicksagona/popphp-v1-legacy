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
 * @package    Pop_Pdf
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Pdf;

/**
 * This is the Root class for the Pdf component.
 *
 * @category   Pop
 * @package    Pop_Pdf
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Root
{

    /**
     * PDF version
     * @var string
     */
    public $version = '1.7';

    /**
     * PDF root object index
     * @var int
     */
    public $index = 1;

    /**
     * PDF root parent object
     * @var int
     */
    public $parent = 2;

    /**
     * PDF root metadata object
     * @var int
     */
    public $metadata = null;

    /**
     * PDF header
     * @var string
     */
    protected $header = '%PDF-';

    /**
     * PDF root object data
     * @var string
     */
    protected $data = null;

    /**
     * Constructor
     *
     * Instantiate a PDF root object.
     *
     * @param  string $str
     * @return void
     */
    public function __construct($str = null)
    {
        // Use default settings for a new PDF and its root object.
        if (null === $str) {
            $this->data = "1 0 obj\n<</Pages 2 0 R/Type/Catalog>>\nendobj\n";
        } else {
            // Else, parse out any metadata and determine the root and parent object indices.
            $this->index = substr($str, 0, strpos($str, ' '));

            // Strip away any metadata reference, recording the metadata object index.
            if (strpos($str, '/Metadata') !== false) {
                $m = substr($str, strpos($str, 'Metadata'));
                $m = substr($m, 0, strpos($m, '/'));
                $m = str_replace('Metadata', '', $m);
                $m = str_replace('0 R', '', $m);
                $m = str_replace(' ', '', $m);
                $this->metadata = $m;

                $m = substr($str, strpos($str, 'Metadata'));
                $m = '/' . substr($m, 0, strpos($m, '/'));
                $str = str_replace($m, '', $str);
            }

            // Determine the parent index.
            $p = substr($str, strpos($str, 'Pages'));
            $p = substr($p, 5, (strpos($p, '0 R') - 5));
            $p = str_replace(' ', '', $p);

            // Set the root object parent index and the data.
            $this->parent = $p;
            $this->data = $str . "\n";
        }
    }

    /**
     * Method to print the root object.
     *
     * @return string
     */
    public function __toString()
    {
        // Set the PDF header and version.
        $obj = $this->header . $this->version . "\n" . $this->data;

        return $obj;
    }

}
