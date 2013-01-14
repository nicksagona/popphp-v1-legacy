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
 * This is the Mail class for the Mail component.
 *
 * @category   Pop
 * @package    Pop_Mail
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.2
 */
class Queue extends \SplQueue
{

    /**
     * Constructor
     *
     * Instantiate the mail queue object.
     *
     * @param  mixed  $email
     * @param  string $name
     * @return \Pop\Mail\Queue
     */
    public function __construct($email = null, $name = null)
    {
        if (null !== $email) {
            if (is_array($email)) {
                $this->addRecipients($email);
            } else {
                $this->addRecipient($email, $name);
            }
        }
    }

    /**
     * Add a recipient
     *
     * @param  string $email
     * @param  string $name
     * @return \Pop\Mail\Queue
     */
    public function add($email, $name = null)
    {
        $rcpt = array();
        if (null !== $name) {
            $rcpt['name'] = $name;
        }
        $rcpt['email'] = $email;

        return $this->addRecipients($rcpt);
    }

    /**
     * Add recipients
     *
     * @param  array $rcpts
     * @throws Exception
     * @return \Pop\Mail\Queue
     */
    public function addRecipients(array $rcpts)
    {
        if (isset($rcpts[0]) && (is_array($rcpts[0]))) {
            foreach ($rcpts as $rcpt) {
                if (!array_key_exists('email', $rcpt)) {
                    throw new Exception("Error: At least one of the array keys must be 'email'.");
                }
                $this[] = $rcpt;
            }
        } else {
            if (!array_key_exists('email', $rcpts)) {
                throw new Exception("Error: At least one of the array keys must be 'email'.");
            }
            $this[] = $rcpts;
        }

        return $this;
    }

    /**
     * Build the to string
     *
     * @return string
     */
    public function __toString()
    {
        $to = array();
        foreach ($this as $rcpt) {
            $to[] = (isset($rcpt['name'])) ? $rcpt['name'] . " <" . $rcpt['email'] . ">" : $rcpt['email'];
        }

        return implode(', ', $to);
    }

}
