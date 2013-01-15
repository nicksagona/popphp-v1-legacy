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
 * This is the Message class for the Mail component.
 *
 * @category   Pop
 * @package    Pop_Mail
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.2.0
 */
class Message
{

    /**
     * Constant for text-only email
     * @var int
     */
    const TEXT = 1;

    /**
     * Constant for HTML-only email
     * @var int
     */
    const HTML = 2;

    /**
     * Constant for text and HTML email
     * @var int
     */
    const TEXT_HTML = 3;

    /**
     * Constant for text and file attachment email
     * @var int
     */
    const TEXT_FILE = 4;

    /**
     * Constant for HTML and file attachment email
     * @var int
     */
    const HTML_FILE = 5;

    /**
     * Constant for HTML and file attachment email
     * @var int
     */
    const TEXT_HTML_FILE = 6;

    /**
     * Mail object
     * @var \Pop\Mail\Message
     */
    protected $mail = null;

    /**
     * Message body
     * @var string
     */
    protected $message = null;

    /**
     * MIME boundary
     * @var string
     */
    protected $mimeBoundary = null;

    /**
     * Text part of the message body
     * @var string
     */
    protected $text = null;

    /**
     * HTML part of the message body
     * @var string
     */
    protected $html = null;

    /**
     * Character set
     * @var string
     */
    protected $charset = 'utf-8';

    /**
     * Constructor
     *
     * Instantiate the message object.
     *
     * @param  Mail $mail
     * @return \Pop\Mail\Message
     */
    public function __construct(\Pop\Mail\Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Get MIME boundary
     *
     * @return string
     */
    public function getBoundary()
    {
        return $this->mimeBoundary;
    }

    /**
     * Get character set
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Get text part of the message.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Get HTML part of the message.
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Get the message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set MIME boundary
     *
     * @param  string $bnd
     * @return \Pop\Mail\Message
     */
    public function setBoundary($bnd = null)
    {
        $this->mimeBoundary = (null !== $bnd) ? $bnd : sha1(time());
        return $this;
    }

    /**
     * Set character set
     *
     * @param  string $chr
     * @return \Pop\Mail\Message
     */
    public function setCharset($chr)
    {
        $this->charset = $chr;
        return $this;
    }

    /**
     * Set text part of the message.
     *
     * @param  string $text
     * @return \Pop\Mail\Message
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Set HTML part of the message.
     *
     * @param  string $html
     * @return \Pop\Mail\Message
     */
    public function setHtml($html)
    {
        $this->html = $html;
        return $this;
    }

    /**
     * Initialize the email message.
     *
     * @throws Exception
     * @return \Pop\Mail\Message
     */
    public function init()
    {
        $msgType = $this->getMessageType();

        if (null === $msgType) {
            throw new Exception('Error: The message body elements are not set.');
        }

        if (count($this->mail->getQueue()) == 0) {
            throw new Exception('Error: There are no recipients for this email.');
        }

        $this->message = null;
        $this->setBoundary();

        switch ($msgType) {
            // If the message contains files, HTML and text.
            case self::TEXT_HTML_FILE:
                $this->mail->setHeaders(array(
                    'MIME-Version' => '1.0',
                    'Content-Type' => 'multipart/mixed; boundary="' . $this->getBoundary() . '"' . Mail::EOL . "This is a multi-part message in MIME format.",
                ));

                $attachments = $this->mail->getAttachments();
                foreach ($attachments as $attachment) {
                    $this->message .= $attachment->build($this->getBoundary(), Mail::EOL);
                }

                $this->message .= '--' . $this->getBoundary() . Mail::EOL .
                    'Content-type: text/html; charset=' . $this->getCharset() .
                    Mail::EOL . Mail::EOL . $this->html . Mail::EOL . Mail::EOL;

                $this->message .= '--' . $this->getBoundary() . Mail::EOL .
                    'Content-type: text/plain; charset=' . $this->getCharset() .
                    Mail::EOL . Mail::EOL . $this->text . Mail::EOL . Mail::EOL . '--' .
                    $this->getBoundary() . '--' . Mail::EOL . Mail::EOL;

                break;

            // If the message contains files and HTML.
            case self::HTML_FILE:
                $this->mail->setHeaders(array(
                    'MIME-Version' => '1.0',
                    'Content-Type' => 'multipart/mixed; boundary="' . $this->getBoundary() . '"' . Mail::EOL . "This is a multi-part message in MIME format.",
                ));

                $attachments = $this->mail->getAttachments();
                foreach ($attachments as $attachment) {
                    $this->message .= $attachment->build($this->getBoundary(), Mail::EOL);
                }

                $this->message .= '--' . $this->getBoundary() . Mail::EOL .
                    'Content-type: text/html; charset=' . $this->getCharset() .
                    Mail::EOL . Mail::EOL . $this->html . Mail::EOL . Mail::EOL . '--' .
                    $this->getBoundary() . '--' . Mail::EOL . Mail::EOL;

                break;

            // If the message contains files and text.
            case self::TEXT_FILE:
                $this->mail->setHeaders(array(
                    'MIME-Version' => '1.0',
                    'Content-Type' => 'multipart/mixed; boundary="' . $this->getBoundary() . '"' . Mail::EOL . "This is a multi-part message in MIME format.",
                ));

                $attachments = $this->mail->getAttachments();
                foreach ($attachments as $attachment) {
                    $this->message .= $attachment->build($this->getBoundary(), Mail::EOL);
                }

                $this->message .= '--' . $this->getBoundary() . Mail::EOL .
                    'Content-type: text/plain; charset=' . $this->getCharset() .
                    Mail::EOL . Mail::EOL . $this->text . Mail::EOL . Mail::EOL . '--' .
                    $this->getBoundary() . '--' . Mail::EOL . Mail::EOL;

                break;

            // If the message contains HTML and text.
            case self::TEXT_HTML:
                $this->mail->setHeaders(array(
                    'MIME-Version' => '1.0',
                    'Content-Type' => 'multipart/alternative; boundary="' . $this->getBoundary() . '"' . Mail::EOL . "This is a multi-part message in MIME format.",
                ));

                $this->message .= '--' . $this->getBoundary() . Mail::EOL .
                    'Content-type: text/plain; charset=' . $this->getCharset() .
                    Mail::EOL . Mail::EOL . $this->text . Mail::EOL . Mail::EOL;
                $this->message .= '--' . $this->getBoundary() . Mail::EOL .
                    'Content-type: text/html; charset=' . $this->getCharset() .
                    Mail::EOL . Mail::EOL . $this->html . Mail::EOL . Mail::EOL .
                    '--' . $this->getBoundary() . '--' . Mail::EOL . Mail::EOL;

                break;

            // If the message contains HTML.
            case self::HTML:
                $this->mail->setHeaders(array(
                    'MIME-Version' => '1.0',
                    'Content-Type' => 'multipart/alternative; boundary="' . $this->getBoundary() . '"' . Mail::EOL . "This is a multi-part message in MIME format.",
                ));

                $this->message .= '--' . $this->getBoundary() . Mail::EOL .
                    'Content-type: text/html; charset=' . $this->getCharset() .
                    Mail::EOL . Mail::EOL . $this->html . Mail::EOL . Mail::EOL . '--' .
                    $this->getBoundary() . '--' . Mail::EOL . Mail::EOL;

                break;

            // If the message contains text.
            case self::TEXT:
                $this->mail->setHeaders(array(
                    'Content-Type' => 'text/plain; charset=' . $this->getCharset()
                ));

                $this->message = $this->text . Mail::EOL;

                break;

            // Else if nothing has been set yet
            default:
                $this->message = null;
        }

        return $this;
    }

    /**
     * Get message type.
     *
     * @return string
     */
    protected function getMessageType()
    {
        $type = null;
        $numAttach = count($this->mail->getAttachments());

        if (($numAttach > 0) && (null === $this->html) && (null === $this->text)) {
            $type = null;
        } else if (($numAttach > 0) && (null !== $this->html) && (null !== $this->text)) {
            $type = self::TEXT_HTML_FILE;
        } else if (($numAttach > 0) && (null !== $this->html)) {
            $type = self::HTML_FILE;
        } else if (($numAttach > 0) && (null !== $this->text)) {
            $type = self::TEXT_FILE;
        } else if ((null !== $this->html) && (null !== $this->text)) {
            $type = self::TEXT_HTML;
        } else if (null !== $this->html) {
            $type = self::HTML;
        } else if (null !== $this->text) {
            $type = self::TEXT;
        }

        return $type;
    }

}
