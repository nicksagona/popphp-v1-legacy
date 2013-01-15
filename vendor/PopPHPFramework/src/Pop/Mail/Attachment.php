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
 * @package    Pop_Mail
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Mail;

/**
 * This is the Attachment class for the Mail component.
 *
 * @category   Pop
 * @package    Pop_Mail
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.2
 */
class Attachment
{

    /**
     * File attachment basename
     * @var string
     */
    protected $basename = null;

    /**
     * File attachment encoded content
     * @var string
     */
    protected $encoded = null;

    /**
     * Constructor
     *
     * Instantiate the mail attachment object.
     *
     * @param  string $file
     * @throws Exception
     * @return \Pop\Mail\Attachment
     */
    public function __construct($file)
    {
        // Determine if the file is valid.
        if (!file_exists($file)) {
            throw new Exception('Error: The file does not exist.');
        }

        $fileParts = pathinfo($file);
        $fileContents = file_get_contents($file);

        // Encode the file contents and set the file into the attachments array property.
        $encoded = chunk_split(base64_encode($fileContents));
        $this->basename = $fileParts['basename'];
        $this->encoded = $encoded;
    }

    /**
     * Build attachment
     *
     * @param  string $boundary
     * @param  string $eol
     * @return string
     */
    public function build($boundary, $eol = "\r\n")
    {
        $attachment = $eol . '--' . $boundary.
            $eol . 'Content-Type: file; name="' . $this->basename .
            '"' . $eol . 'Content-Transfer-Encoding: base64' . $eol .
            'Content-Description: ' . $this->basename . $eol .
            'Content-Disposition: attachment; filename="' . $this->basename .
            '"' . $eol . $eol . $this->encoded . $eol . $eol;

        return $attachment;
    }

}
