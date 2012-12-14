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
 * @package    Pop_Log
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Log\Writer;

use Pop\Mail\Mail as PopMail,
    Pop\Validator\Validator\Email;

/**
 * This is the Db writer class for the Log component.
 *
 * @category   Pop
 * @package    Pop_Log
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.3
 */
class Mail implements WriterInterface
{

    /**
     * Array of emails in which to send the log messages
     * @var array
     */
    protected $emails = array();

    /**
     * Constructor
     *
     * Instantiate the Mail writer object.
     *
     * @param  array $emails
     * @throws Exception
     * @return \Pop\Log\Writer\Mail
     */
    public function __construct(array $emails)
    {
        if (count($emails) == 0) {
            throw new Exception('Error: There must be at least one email address passed.');
        }

        $validator = new Email();
        foreach ($emails as $key => $value) {
            if (!$validator->evaluate($value)) {
                throw new Exception('Error: One of the email addresses passed was not valid.');
            }
            if (!is_numeric($key)) {
                $this->emails[] = array(
                    'name'  => $key,
                    'email' => $value
                );
            } else {
                $this->emails[] = array(
                    'email' => $value
                );
            }

        }
    }

    /**
     * Method to write to the log
     *
     * @param  array $logEntry
     * @param  array $options
     * @return \Pop\Log\Writer\Db
     */
    public function writeLog(array $logEntry, array $options = array())
    {
        $subject = (isset($options['subject'])) ?
            $options['subject'] :
            'Log Entry:';

        $subject .= ' ' . $logEntry['name'] . ' (' . $logEntry['priority'] . ')';

        $mail = new PopMail($this->emails, $subject);
        if (isset($options['headers'])) {
            $mail->setHeaders($options['headers']);
        }

        $entry = implode("\t", $logEntry) . PHP_EOL;
        if (isset($options['body'])) {
            $entry .= PHP_EOL . $options['body'] . PHP_EOL;
        }

        $mail->setText($entry)
             ->send();

        return $this;
    }

}
