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

use Pop\File\File;

/**
 * This is the Mail class for the Mail component.
 *
 * @category   Pop
 * @package    Pop_Mail
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.2
 */
class Mail
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
     * Sending queue
     * @var \Pop\Mail\Queue
     */
    protected $queue = null;

    /**
     * Mail headers
     * @var array
     */
    protected $headers = array();

    /**
     * Subject
     * @var string
     */
    protected $subject = null;

    /**
     * Message body
     * @var string
     */
    protected $message = null;

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
     * Mail parameters
     * @var string
     */
    protected $params = null;

    /**
     * Character set
     * @var string
     */
    protected $charset = 'utf-8';

    /**
     * MIME boundary
     * @var string
     */
    protected $mimeBoundary = null;

    /**
     * File attachments
     * @var array
     */
    protected $attachments = array();

    /**
     * End of line
     * @var string
     */
    protected $eol = "\r\n";

    /**
     * Send as group flag
     * @var boolean
     */
    protected $group = false;

    /**
     * Constructor
     *
     * Instantiate the mail object.
     *
     * @param  string $subj
     * @param  array  $rcpts
     * @return \Pop\Mail\Mail
     */
    public function __construct($subj = null, array $rcpts = null)
    {
        $this->subject = $subj;
        $this->queue = new Queue();

        if (null !== $rcpts) {
            $this->addRecipients($rcpts);
        }
    }

    /**
     * Get the mail queue
     *
     * @return array
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * Get the mail header
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get the mail header
     *
     * @param  string $name
     * @return string
     */
    public function getHeader($name)
    {
        return (isset($this->headers[$name])) ? $this->headers[$name] : null;
    }

    /**
     * Get the subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
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
     * Get the end of line
     *
     * @return string
     */
    public function getEol()
    {
        return $this->eol;
    }

    /**
     * Alias to add a recipient to the queue
     *
     * @param  string $email
     * @param  string $name
     * @return \Pop\Mail\Mail
     */
    public function to($email, $name = null)
    {
        $this->queue->add($email, $name);
        return $this;
    }

    /**
     * Add a recipient to the queue
     *
     * @param  string $email
     * @param  string $name
     * @return \Pop\Mail\Mail
     */
    public function add($email, $name = null)
    {
        $this->queue->add($email, $name);
        return $this;
    }

    /**
     * Add recipients to the queue
     *
     * @param  array $rcpts
     * @throws Exception
     * @return \Pop\Mail\Mail
     */
    public function addRecipients(array $rcpts)
    {
        if (isset($rcpts[0]) && (is_array($rcpts[0]))) {
            foreach ($rcpts as $rcpt) {
                if (!array_key_exists('email', $rcpt)) {
                    throw new Exception("Error: At least one of the array keys must be 'email'.");
                }
                $this->queue[] = $rcpt;
            }
        } else {
            if (!array_key_exists('email', $rcpts)) {
                throw new Exception("Error: At least one of the array keys must be 'email'.");
            }
            $this->queue[] = $rcpts;
        }

        return $this;
    }

    /**
     * Alias to set the from and reply-to headers
     *
     * @param  string  $email
     * @param  string  $name
     * @param  boolean $replyTo
     * @return \Pop\Mail\Mail
     */
    public function from($email, $name = null, $replyTo = true)
    {
        $header = (null !== $name) ? $name . ' <' . $email . '>' : $email;
        $this->setHeader('From', $header);
        if ($replyTo) {
            $this->setHeader('Reply-To', $header);
        }

        return $this;
    }

    /**
     * Alias to set the from and reply-to headers
     *
     * @param  string  $email
     * @param  string  $name
     * @param  boolean $from
     * @return \Pop\Mail\Mail
     */
    public function replyTo($email, $name = null, $from = true)
    {
        $header = (null !== $name) ? $name . ' <' . $email . '>' : $email;
        $this->setHeader('Reply-To', $header);
        if ($from) {
            $this->setHeader('From', $header);
        }

        return $this;
    }

    /**
     * Set a mail header
     *
     * @param  string $name
     * @param  string $value
     * @throws Exception
     * @return \Pop\Mail\Mail
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Set mail headers
     *
     * @param  array $headers
     * @throws Exception
     * @return \Pop\Mail\Mail
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $name => $value) {
            $this->setHeader($name, $value);
        }

        return $this;
    }

    /**
     * Set the subject
     *
     * @param  string $subj
     * @return \Pop\Mail\Mail
     */
    public function setSubject($subj)
    {
        $this->subject = $subj;
        return $this;
    }

    /**
     * Set MIME boundary
     *
     * @param  string $bnd
     * @return \Pop\Mail\Mail
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
     * @return \Pop\Mail\Mail
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
     * @return \Pop\Mail\Mail
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
     * @return \Pop\Mail\Mail
     */
    public function setHtml($html)
    {
        $this->html = $html;
        return $this;
    }

    /**
     * Set the end of line
     *
     * @param  string $eol
     * @return \Pop\Mail\Mail
     */
    public function setEol($eol)
    {
        $this->eol = $eol;
        return $this;
    }

    /**
     * Set the send as group flag
     *
     * @param  boolean
     * @return \Pop\Mail\Mail
     */
    public function sendAsGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * Attach a file to the mail object.
     *
     * @param  string $file
     * @throws Exception
     * @return \Pop\Mail\Mail
     */
    public function attachFile($file)
    {
        $this->attachments[] = new Attachment($file);
        return $this;
    }

    /**
     * Set parameters
     *
     * @param  string|array $params
     * @return \Pop\Mail\Mail
     */
    public function setParams($params = null)
    {
        if (null === $params) {
            $this->params = null;
        } else if (is_array($params)) {
            foreach ($params as $value) {
                $this->params .= $value;
            }
        } else {
            $this->params .= $params;
        }

        return $this;
    }

    /**
     * Initialize the email message.
     *
     * @throws Exception
     * @return \Pop\Mail\Mail
     */
    public function init()
    {
        $msgType = $this->getMessageType();

        if (null === $msgType) {
            throw new Exception('Error: The message body elements are not set.');
        }

        if (count($this->queue) == 0) {
            throw new Exception('Error: There are no recipients for this email.');
        }

        $this->message = null;
        $this->setBoundary();

        switch ($msgType) {
            // If the message contains files, HTML and text.
            case self::TEXT_HTML_FILE:
                $this->setHeaders(array(
                    'MIME-Version' => '1.0',
                    'Content-Type' => 'multipart/mixed; boundary="' . $this->getBoundary() . '"' . $this->eol . "This is a multi-part message in MIME format.",
                ));

                foreach ($this->attachments as $attachment) {
                    $this->message .= $attachment->build($this->getBoundary(), $this->eol);
                }

                $this->message .= '--' . $this->getBoundary() . $this->eol .
                    'Content-type: text/html; charset=' . $this->getCharset() .
                    $this->eol . $this->eol . $this->html . $this->eol . $this->eol;

                $this->message .= '--' . $this->getBoundary() . $this->eol .
                    'Content-type: text/plain; charset=' . $this->getCharset() .
                    $this->eol . $this->eol . $this->text . $this->eol . $this->eol . '--' .
                    $this->getBoundary() . '--' . $this->eol . $this->eol;

                break;

            // If the message contains files and HTML.
            case self::HTML_FILE:
                $this->setHeaders(array(
                    'MIME-Version' => '1.0',
                    'Content-Type' => 'multipart/mixed; boundary="' . $this->getBoundary() . '"' . $this->eol . "This is a multi-part message in MIME format.",
                ));

                foreach ($this->attachments as $attachment) {
                    $this->message .= $attachment->build($this->getBoundary(), $this->eol);
                }

                $this->message .= '--' . $this->getBoundary() . $this->eol .
                    'Content-type: text/html; charset=' . $this->getCharset() .
                    $this->eol . $this->eol . $this->html . $this->eol . $this->eol . '--' .
                    $this->getBoundary() . '--' . $this->eol . $this->eol;

                break;

            // If the message contains files and text.
            case self::TEXT_FILE:
                $this->setHeaders(array(
                    'MIME-Version' => '1.0',
                    'Content-Type' => 'multipart/mixed; boundary="' . $this->getBoundary() . '"' . $this->eol . "This is a multi-part message in MIME format.",
                ));

                foreach ($this->attachments as $attachment) {
                    $this->message .= $attachment->build($this->getBoundary(), $this->eol);
                }

                $this->message .= '--' . $this->getBoundary() . $this->eol .
                    'Content-type: text/plain; charset=' . $this->getCharset() .
                    $this->eol . $this->eol . $this->text . $this->eol . $this->eol . '--' .
                    $this->getBoundary() . '--' . $this->eol . $this->eol;

                break;

            // If the message contains HTML and text.
            case self::TEXT_HTML:
                $this->setHeaders(array(
                    'MIME-Version' => '1.0',
                    'Content-Type' => 'multipart/alternative; boundary="' . $this->getBoundary() . '"' . $this->eol . "This is a multi-part message in MIME format.",
                ));

                $this->message .= '--' . $this->getBoundary() . $this->eol .
                    'Content-type: text/plain; charset=' . $this->getCharset() .
                    $this->eol . $this->eol . $this->text . $this->eol . $this->eol;
                $this->message .= '--' . $this->getBoundary() . $this->eol .
                    'Content-type: text/html; charset=' . $this->getCharset() .
                    $this->eol . $this->eol . $this->html . $this->eol . $this->eol .
                    '--' . $this->getBoundary() . '--' . $this->eol . $this->eol;

                break;

            // If the message contains HTML.
            case self::HTML:
                $this->setHeaders(array(
                    'MIME-Version' => '1.0',
                    'Content-Type' => 'multipart/alternative; boundary="' . $this->getBoundary() . '"' . $this->eol . "This is a multi-part message in MIME format.",
                ));

                $this->message .= '--' . $this->getBoundary() . $this->eol .
                    'Content-type: text/html; charset=' . $this->getCharset() .
                    $this->eol . $this->eol . $this->html . $this->eol . $this->eol . '--' .
                    $this->getBoundary() . '--' . $this->eol . $this->eol;

                break;

            // If the message contains text.
            case self::TEXT:
                $this->setHeaders(array(
                    'Content-Type' => 'text/plain; charset=' . $this->getCharset()
                ));

                $this->message = $this->text . $this->eol;

                break;

            // Else if nothing has been set yet
            default:
                $this->message = null;
        }

        return $this;
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
        if (null === $this->message) {
            $this->init();
        }

        $headers = $this->buildHeaders() . $this->eol . $this->eol;

        // Send as group message
        if ($this->group) {
            mail((string)$this->queue, $this->subject, $this->message, $headers, $this->params);
        // Else, Iterate through the queue and send the mail messages.
        } else {
            foreach ($this->queue as $rcpt) {
                $subject = $this->subject;
                $message = $this->message;

                // Set the recipient parameter.
                $to = (isset($rcpt['name'])) ? $rcpt['name'] . " <" . $rcpt['email'] . ">" : $rcpt['email'];

                // Replace any set placeholder content within the subject or message.
                foreach ($rcpt as $key => $value) {
                    $subject =  str_replace('[{' . $key . '}]', $value, $subject);
                    $message =  str_replace('[{' . $key . '}]', $value, $message);
                }

                // Send the email message.
                mail($to, $subject, $message, $headers, $this->params);
            }
        }
    }

    /**
     * Save mail message or messages in a folder to be sent at a later date.
     *
     * @param string $to
     * @param string $format
     * @return \Pop\Mail\Mail
     */
    public function saveTo($to = null, $format = null)
    {
        $dir = (null !== $to) ? $to : getcwd();

        if (null === $this->message) {
            $this->init();
        }

        $headers = $this->buildHeaders();

        // Send as group message
        if ($this->group) {
            $email = 'To: ' . (string)$this->queue . $this->eol .
                'Subject: ' . $this->subject . $this->eol .
                $headers . $this->eol . $this->eol . $this->message;

            $emailFileName = (null !== $format) ? $format : $emailFileName = '0000000001-' . time() . '-popphpmail';

            // Save the email message.
            $file = new File($dir . DIRECTORY_SEPARATOR . $emailFileName, array());
            $file->write($email)
                 ->save();
        } else {
            // Iterate through the queue and send the mail messages.
            $i = 1;
            foreach ($this->queue as $rcpt) {
                $fileFormat = null;
                $subject = $this->subject;
                $message = $this->message;

                // Set the recipient parameter.
                $to = (isset($rcpt['name'])) ? $rcpt['name'] . " <" . $rcpt['email'] . ">" : $rcpt['email'];

                // Replace any set placeholder content within the subject or message.
                foreach ($rcpt as $key => $value) {
                    $subject =  str_replace('[{' . $key . '}]', $value, $subject);
                    $message =  str_replace('[{' . $key . '}]', $value, $message);
                    if (null !== $format) {
                        if (null !== $fileFormat) {
                            $fileFormat = str_replace('[{' . $key . '}]', $value, $fileFormat);
                        } else {
                            $fileFormat = str_replace('[{' . $key . '}]', $value, $format);
                        }
                    }
                }

                $email = 'To: ' . $to . $this->eol .
                         'Subject: ' . $subject . $this->eol .
                         $headers . $this->eol . $this->eol . $message;

                if (null !== $fileFormat) {
                    $emailFileName = sprintf('%09d', $i) . '-' . time() . '-' . $fileFormat;
                } else {
                    $emailFileName = sprintf('%09d', $i) . '-' . time() . '-popphpmail';
                }

                // Save the email message.
                $file = new File($dir . DIRECTORY_SEPARATOR . $emailFileName, array());
                $file->write($email)
                     ->save();

                $i++;
            }
        }

        return $this;
    }

    /**
     * Send mail message or messages that are saved in a folder.
     *
     * This method depends on the server being set up correctly as an SMTP server
     * and sendmail being correctly defined in the php.ini file.
     *
     * @param string  $from
     * @param boolean $delete
     * @return \Pop\Mail\Mail
     */
    public function sendFrom($from = null, $delete = false)
    {
        $dir = (null !== $from) ? $from : getcwd();
        $emailDir = new \Pop\File\Dir($dir, true);
        $emailFiles = $emailDir->getFiles();
        if (isset($emailFiles[0])) {
            foreach ($emailFiles as $email) {
                if (file_exists($email)) {
                    // Get the email data from the contents
                    $emailData = $this->getEmailFromFile($email);

                    // Send the email message.
                    mail($emailData['to'], $emailData['subject'], $emailData['message'], $emailData['headers'], $this->params);

                    // Delete the email file is the flag is passed
                    if ($delete) {
                        unlink($email);
                    }
                }
            }
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

        if ((count($this->attachments) > 0) && (null === $this->html) && (null === $this->text)) {
            $type = null;
        } else if ((count($this->attachments) > 0) && (null !== $this->html) && (null !== $this->text)) {
            $type = self::TEXT_HTML_FILE;
        } else if ((count($this->attachments) > 0) && (null !== $this->html)) {
            $type = self::HTML_FILE;
        } else if ((count($this->attachments) > 0) && (null !== $this->text)) {
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

    /**
     * Build headers
     *
     * @return string
     */
    protected function buildHeaders()
    {
        $headers = null;
        foreach ($this->headers as $key => $value) {
            $headers .= (is_array($value)) ? $key . ": " . $value[0] . " <" . $value[1] . ">" . $this->eol : $key . ": " . $value . $this->eol;
        }

        return $headers;
    }

    /**
     * Get email data from file
     *
     * @param  string $filename
     * @throws Exception
     * @return array
     */
    protected function getEmailFromFile($filename)
    {
        $contents = file_get_contents($filename);
        $email = array(
            'to'      => null,
            'subject' => null,
            'headers' => null,
            'message' => null
        );

        $headers = substr($contents, 0, strpos($contents, $this->eol . $this->eol));
        $email['message'] = trim(str_replace($headers, '', $contents));
        $email['headers'] = trim($headers) . $this->eol . $this->eol;

        if (strpos($email['headers'], 'Subject:') === false) {
            throw new Exception("Error: There is no subject in the email file '" . $filename . "'.");
        }

        if (strpos($email['headers'], 'To:') === false) {
            throw new Exception("Error: There is no recipient in the email file '" . $filename . "'.");
        }

        $subject = substr($contents, strpos($contents, 'Subject:'));
        $subject = substr($subject, 0, strpos($subject, $this->eol));
        $email['headers'] = str_replace($subject . $this->eol, '', $email['headers']);
        $email['subject'] = trim(substr($subject . $this->eol, (strpos($subject, ':') + 1)));

        $to = substr($contents, strpos($contents, 'To:'));
        $to = substr($to, 0, strpos($to, $this->eol));
        $email['headers'] = str_replace($to . $this->eol, '', $email['headers']);

        preg_match('/[a-zA-Z0-9\.\-\_+%]+@[a-zA-Z0-9\-\_\.]+\.[a-zA-Z]{2,4}/', $to, $result);

        if (!isset($result[0])) {
            throw new Exception("Error: An valid email could not be parsed from the email file '" . $filename . "'.");
        } else {
            $email['to'] = $result[0];
        }

        return $email;
    }

}
