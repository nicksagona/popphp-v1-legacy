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
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @category   Pop
 * @package    Pop_Mail
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */

/**
 * @namespace
 */
namespace Pop\Mail;
use Pop\File\File,
    Pop\Locale\Locale;

class Mail
{

    /**
     * Sending queue
     * @var array
     */
    protected $_queue = array();

    /**
     * Subject
     * @var string
     */
    protected $_subject = null;

    /**
     * Message body
     * @var string
     */
    protected $_message = null;

    /**
     * Text part of the message body
     * @var string
     */
    protected $_text = null;

    /**
     * HTML part of the message body
     * @var string
     */
    protected $_html = null;

    /**
     * Mail headers
     * @var string
     */
    protected $_headers = null;

    /**
     * Mail parameters
     * @var string
     */
    protected $_params = null;

    /**
     * Character set
     * @var string
     */
    protected $_charset = 'utf-8';

    /**
     * MIME boundary
     * @var string
     */
    protected $_mime_boundary = null;

    /**
     * File attachments
     * @var array
     */
    protected $_attachments = array();

    /**
     * Language object
     * @var Pop_Locale
     */
    protected $_lang = null;

    /**
     * Constructor
     *
     * Instantiate the mail object.
     *
     * @param  string|array $em
     * @param  string       $nm
     * @param  string       $subj
     * @throws Exception
     * @return void
     */
    public function __construct($em, $nm = null, $subj = null)
    {
        $this->_lang = new Locale();

        $this->_subject = $subj;

        // If the email parameter passed is an array, set accordingly.
        if (is_array($em)) {
            foreach ($em as $value) {
                if (is_array($value)) {
                    if (!array_key_exists('email', $value)) {
                        throw new Exception($this->_lang->__("Error: At least one of the array keys must be 'email'."));
                    } else {
                        $this->_queue[] = $value;
                    }
                } else {
                    $this->_queue[] = array('email' => $value);
                }
            }
        // Else, set the single email value.
        } else {
            if (null !== $nm) {
                $this->_queue[] = array('name' => $nm, 'email' => $em);
            } else {
                $this->_queue[] = array('email' => $em);
            }
        }
    }

    /**
     * Set the subject
     *
     * @param  string $subj
     * @return Pop_Mail
     */
    public function setSubject($subj)
    {
        $this->_subject = $subj;
        return $this;
    }

    /**
     * Get the subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->_subject;
    }

    /**
     * Set MIME boundary
     *
     * @param  string $bnd
     * @return Pop_Mail
     */
    public function setBoundary($bnd = null)
    {
        $this->_mime_boundary = (null !== $bnd) ? $bnd : sha1(time());
        return $this;
    }

    /**
     * Get MIME boundary
     *
     * @return string
     */
    public function getBoundary()
    {
        return $this->_mime_boundary;
    }

    /**
     * Set character set
     *
     * @param  string $chr
     * @return Pop_Mail
     */
    public function setCharset($chr)
    {
        $this->_charset = $chr;
        return $this;
    }

    /**
     * Get character set
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->_charset;
    }

    /**
     * Set text part of the message.
     *
     * @param  string $txt
     * @return Pop_Mail
     */
    public function setText($txt)
    {
        $this->_text = $txt;
        return $this;
    }

    /**
     * Set HTML part of the message.
     *
     * @param  string $html
     * @return Pop_Mail
     */
    public function setHtml($html)
    {
        $this->_html = $html;
        return $this;
    }

    /**
     * Attach a file to the mail object.
     *
     * @param  string|Pop_File $file
     * @throws Exception
     * @return Pop_Mail
     */
    public function attachFile($file)
    {
        // Determine if the file is valid.
        if (((is_string($file)) && (!file_exists($file))) && (!($file instanceof File))) {
            throw new Exception($this->_lang->__('Error: The parameter passed must either be a valid file or an instance of Pop_File.'));
        } else if (is_string($file)) {
            $fle = new File($file);
        } else {
            $fle = $file;
        }

        // Encode the file contents and set the file into the attachments array property.
        $contents = chunk_split(base64_encode($fle->read()));
        $this->_attachments[] = array('file' => $fle, 'contents' => $contents);

        return $this;
    }

    /**
     * Set headers
     *
     * @param  string|array $hdrs
     * @return Pop_Mail
     */
    public function setHeaders($hdrs = null)
    {
        if (null === $hdrs) {
            $this->_headers = null;
        } else if (is_array($hdrs)) {
            foreach ($hdrs as $key => $value) {
                $this->_headers .= (is_array($value)) ? $key . ": " . $value[0] . " <" . $value[1] . ">" . PHP_EOL : $key . ": " . $value . PHP_EOL;
            }
        } else {
            $this->_headers .= $hdrs;
        }

        return $this;
    }

    /**
     * Set parameters
     *
     * @param  string|array $params
     * @return Pop_Mail
     */
    public function setParams($params = null)
    {
        if (null === $params) {
            $this->_params = null;
        } else if (is_array($params)) {
            foreach ($params as $value) {
                $this->_params .= $value;
            }
        } else {
            $this->_params .= $params;
        }

        return $this;
    }

    /**
     * Initialize the email message.
     *
     * @throws Exception
     * @return void
     */
    public function init()
    {
        $msgType = $this->_getMessageType();

        if (null === $msgType) {
            throw new Exception($this->_lang->__('Error: The message body elements are not set.'));
        } else {
            $this->setBoundary();

            switch ($msgType) {
                // If the message contains files, HTML and text.
                case 'FILE|HTML|TEXT':
                    $this->_headers .= "MIME-Version: 1.0" . PHP_EOL . "Content-Type: multipart/mixed; boundary=\"" . $this->getBoundary() . "\"" . PHP_EOL . "This is a multi-part message in MIME format." . PHP_EOL . PHP_EOL;
                    foreach ($this->_attachments as $file) {
                        $this->_message .= "" . PHP_EOL . "--" . $this->getBoundary() . "" . PHP_EOL . "Content-Type: file; name=\"" . $file['file']->basename . "\"" . PHP_EOL . "Content-Transfer-Encoding: base64" . PHP_EOL . "Content-Description: " . $file['file']->basename . "" . PHP_EOL . "Content-Disposition: attachment; filename=\"" . $file['file']->basename . "\"" . PHP_EOL . PHP_EOL . $file['contents'] . PHP_EOL . PHP_EOL;
                    }
                    $this->_message .= "--" . $this->getBoundary() . "" . PHP_EOL . "Content-type: text/html; charset=" . $this->getCharset() . PHP_EOL . PHP_EOL . $this->_html . PHP_EOL . PHP_EOL;
                    $this->_message .= "--" . $this->getBoundary() . "" . PHP_EOL . "Content-type: text/plain; charset=" . $this->getCharset() . PHP_EOL . PHP_EOL . $this->_text . PHP_EOL . PHP_EOL . "--" . $this->getBoundary() . "--" . PHP_EOL . PHP_EOL;
                    break;

                // If the message contains files and HTML.
                case 'FILE|HTML':
                    $this->_headers .= "MIME-Version: 1.0" . PHP_EOL . "Content-Type: multipart/mixed; boundary=\"" . $this->getBoundary() . "\"" . PHP_EOL . "This is a multi-part message in MIME format." . PHP_EOL;
                    foreach ($this->_attachments as $file) {
                        $this->_message .= "" . PHP_EOL . "--" . $this->getBoundary() . PHP_EOL . "Content-Type: file; name=\"" . $file['file']->basename . "\"" . PHP_EOL . "Content-Transfer-Encoding: base64" . PHP_EOL . "Content-Description: " . $file['file']->basename . PHP_EOL . "Content-Disposition: attachment; filename=\"" . $file['file']->basename . "\"" . PHP_EOL . PHP_EOL . $file['contents'] . PHP_EOL . PHP_EOL;
                    }
                    $this->_message .= "--" . $this->getBoundary() . PHP_EOL . "Content-type: text/html; charset=" . $this->getCharset() . PHP_EOL . PHP_EOL . $this->_html . PHP_EOL . PHP_EOL . "--" . $this->getBoundary() . "--" . PHP_EOL . PHP_EOL;
                    break;

                // If the message contains files and text.
                case 'FILE|TEXT':
                    $this->_headers .= "MIME-Version: 1.0" . PHP_EOL . "Content-Type: multipart/mixed; boundary=\"" . $this->getBoundary() . "\"" . PHP_EOL . "This is a multi-part message in MIME format." . PHP_EOL . PHP_EOL;
                    foreach ($this->_attachments as $file) {
                        $this->_message .= PHP_EOL . "--" . $this->getBoundary() . PHP_EOL . "Content-Type: file; name=\"" . $file['file']->basename . "\"" . PHP_EOL . "Content-Transfer-Encoding: base64" . PHP_EOL . "Content-Description: " . $file['file']->basename . PHP_EOL . "Content-Disposition: attachment; filename=\"" . $file['file']->basename . "\"" . PHP_EOL . PHP_EOL . $file['contents'] . PHP_EOL . PHP_EOL;
                    }
                    $this->_message .= "--" . $this->getBoundary() . PHP_EOL . "Content-type: text/plain; charset=" . $this->getCharset() . PHP_EOL . PHP_EOL . $this->_text . PHP_EOL . PHP_EOL . "--" . $this->getBoundary() . "--" . PHP_EOL . PHP_EOL;
                    break;

                // If the message contains HTML and text.
                case 'HTML|TEXT':
                    $this->_headers .= "MIME-Version: 1.0" . PHP_EOL . "Content-Type: multipart/alternative; boundary=\"" . $this->getBoundary() . "\"" . PHP_EOL . "This is a multi-part message in MIME format." . PHP_EOL . PHP_EOL;
                    $this->_message .= "--" . $this->getBoundary() . PHP_EOL . "Content-type: text/plain; charset=" . $this->getCharset() . PHP_EOL . PHP_EOL . $this->_text . PHP_EOL . PHP_EOL;
                    $this->_message .= "--" . $this->getBoundary() . PHP_EOL . "Content-type: text/html; charset=" . $this->getCharset() . PHP_EOL . PHP_EOL . $this->_html . PHP_EOL . PHP_EOL . "--" . $this->getBoundary() . "--" . PHP_EOL . PHP_EOL;
                    break;

                // If the message contains HTML.
                case 'HTML':
                    $this->_headers .= "MIME-Version: 1.0" . PHP_EOL . "Content-Type: multipart/alternative; boundary=\"" . $this->getBoundary() . "\"" . PHP_EOL . "This is a multi-part message in MIME format." . PHP_EOL . PHP_EOL;
                    $this->_message .= "--" . $this->getBoundary() . PHP_EOL . "Content-type: text/html; charset=" . $this->getCharset() . PHP_EOL . PHP_EOL . $this->_html . PHP_EOL . PHP_EOL . "--" . $this->getBoundary() . "--" . PHP_EOL . PHP_EOL;
                    break;

                // If the message contains text.
                case 'TEXT':
                    $this->_headers .= "Content-Type: text/plain; charset=" . $this->getCharset() . PHP_EOL;
                    $this->_message = $this->_text . PHP_EOL;
                    break;
            }
        }
    }

    /**
     * Send mail message or messages.
     *
     * This method depends on the server being set up correctly as an SMTP server
     * and sendmail being correctly defined in the php.ini file.
     *
     * @return void
     */
    public function send()
    {
        // Iterate through the queue and send the mail messages.
        foreach ($this->_queue as $rcpt) {
            $subject = $this->_subject;
            $message = $this->_message;

            // Set the recipient parameter.
            $to = (isset($rcpt['name'])) ? $rcpt['name'] . " <" . $rcpt['email'] . ">" : $rcpt['email'];

            // Replace any set placeholder content within the subject or message.
            foreach ($rcpt as $key => $value) {
                $subject =  str_replace('[{' . $key . '}]', $value, $subject);
                $message =  str_replace('[{' . $key . '}]', $value, $message);
            }

            // Send the email message.
            mail($to, $subject, $message, $this->_headers, $this->_params);
        }
    }

    /**
     * Get message type.
     *
     * @return string
     */
    protected function _getMessageType()
    {
        if ((count($this->_attachments) > 0) && (null === $this->_html) && (null === $this->_text)) {
            $type = null;
        } else if ((count($this->_attachments) > 0) && (null !== $this->_html) && (null !== $this->_text)) {
            $type = 'FILE|HTML|TEXT';
        } else if ((count($this->_attachments) > 0) && (null !== $this->_html)) {
            $type = 'FILE|HTML';
        } else if ((count($this->_attachments) > 0) && (null !== $this->_text)) {
            $type = 'FILE|TEXT';
        } else if ((null !== $this->_html) && (null !== $this->_text)) {
            $type = 'HTML|TEXT';
        } else if (null !== $this->_html) {
            $type = 'HTML';
        } else if (null !== $this->_text) {
            $type = 'TEXT';
        }

        return $type;
    }

}
