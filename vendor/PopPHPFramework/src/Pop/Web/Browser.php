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
 * @package    Pop_Web
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Web;

/**
 * This is the Browser class for the Web component.
 *
 * @category   Pop
 * @package    Pop_Web
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.1
 */
class Browser
{

    /**
     * User IP address
     * @var string
     */
    public $ip = null;

    /**
     * User Subnet
     * @var string
     */
    public $subnet = null;

    /**
     * User agent property
     * @var string
     */
    public $ua = null;

    /**
     * Platform
     * @var string
     */
    public $platform = null;

    /**
     * Operating system
     * @var string
     */
    public $os = null;

    /**
     * Browser
     * @var string
     */
    public $browser = null;

    /**
     * Browser version
     * @var string
     */
    public $version = null;

    /**
     * Constructor
     *
     * Instantiate the browser session object.
     *
     * @return void
     */
    public function __construct()
    {
        // Set the user agent and object properties.
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->subnet = substr($_SERVER['REMOTE_ADDR'], 0, strrpos($_SERVER['REMOTE_ADDR'], '.'));
        $this->ua = $_SERVER['HTTP_USER_AGENT'];
        $this->detect();
    }

    /**
     * Method to detect properties.
     *
     * @return void
     */
    protected function detect()
    {
        // Determine system platform and OS version.
        if (stripos($this->ua, 'Windows') !== false) {
            $this->platform = 'Windows';
            $this->os = (stripos($this->ua, 'Windows NT') !== false) ? substr($this->ua, stripos($this->ua, 'Windows NT'), 14) : 'Windows';
        } else if (stripos($this->ua, 'Macintosh') !== false) {
            $this->platform = 'Macintosh';
            if (stripos($this->ua, 'Intel') !== false) {
                $this->os = substr($this->ua, stripos($this->ua, 'Intel'));
                $this->os = substr($this->os, 0, stripos($this->os, ';'));
            } else if (stripos($this->ua, 'PPC') !== false) {
                $this->os = substr($this->ua, stripos($this->ua, 'PPC'));
                $this->os = substr($this->os, 0, stripos($this->os, ';'));
            } else {
                $this->os = 'Macintosh';
            }
        } else if (stripos($this->ua, 'Linux') !== false) {
            $this->platform = 'Linux';
            if (stripos($this->ua, 'Linux') !== false) {
                $this->os = substr($this->ua, stripos($this->ua, 'Linux '));
                $this->os = substr($this->os, 0, stripos($this->os, ';'));
            } else {
                $this->os = 'Linux';
            }
        } else if (stripos($this->ua, 'SunOS') !== false) {
            $this->platform = 'SunOS';
            if (stripos($this->ua, 'SunOS') !== false) {
                $this->os = substr($this->ua, stripos($this->ua, 'SunOS '));
                $this->os = substr($this->os, 0, stripos($this->os, ';'));
            } else {
                $this->os = 'SunOS';
            }
        } else if (stripos($this->ua, 'OpenBSD') !== false) {
            $this->platform = 'OpenBSD';
            if (stripos($this->ua, 'OpenBSD') !== false) {
                $this->os = substr($this->ua, stripos($this->ua, 'OpenBSD '));
                $this->os = substr($this->os, 0, stripos($this->os, ';'));
            } else {
                $this->os = 'OpenBSD';
            }
        } else if (stripos($this->ua, 'NetBSD') !== false) {
            $this->platform = 'NetBSD';
            if (stripos($this->ua, 'NetBSD') !== false) {
                $this->os = substr($this->ua, stripos($this->ua, 'NetBSD '));
                $this->os = substr($this->os, 0, stripos($this->os, ';'));
            } else {
                $this->os = 'NetBSD';
            }
        } else if (stripos($this->ua, 'FreeBSD') !== false) {
            $this->platform = 'FreeBSD';
            if (stripos($this->ua, 'FreeBSD') !== false) {
                $this->os = substr($this->ua, stripos($this->ua, 'FreeBSD '));
                $this->os = substr($this->os, 0, stripos($this->os, ';'));
            } else {
                $this->os = 'FreeBSD';
            }
        }

        // Determine browser and browser version.
        if (stripos($this->ua, 'Camino') !== false) {
            $this->browser = 'Camino';
            $this->version = substr($this->ua, (stripos($this->ua, 'Camino/') + 7));
        } else if (stripos($this->ua, 'Chrome') !== false) {
            $this->browser = 'Chrome';
            $this->version = substr($this->ua, (stripos($this->ua, 'Chrome/') + 7));
            $this->version = substr($this->version, 0, (stripos($this->version, ' ')));
        } else if (stripos($this->ua, 'Firefox') !== false) {
            $this->browser = 'Firefox';
            $this->version = substr($this->ua, (stripos($this->ua, 'Firefox/') + 8));
        } else if (stripos($this->ua, 'MSIE') !== false) {
            $this->browser = 'MSIE';
            $this->version = substr($this->ua, (stripos($this->ua, 'MSIE ') + 5));
            $this->version = substr($this->version, 0, stripos($this->version, ';'));
        } else if (stripos($this->ua, 'Konqueror') !== false) {
            $this->browser = 'Konqueror';
            $this->version = substr($this->ua, (stripos($this->ua, 'Konqueror/') + 10));
            $this->version = substr($this->version, 0, stripos($this->version, ';'));
        } else if (stripos($this->ua, 'Navigator') !== false) {
            $this->browser = 'Navigator';
            $this->version = substr($this->ua, (stripos($this->ua, 'Navigator/') + 10));
        } else if (stripos($this->ua, 'Opera') !== false) {
            $this->browser = 'Opera';
            $this->version = substr($this->ua, (stripos($this->ua, 'Opera/') + 6));
            $this->version = substr($this->version, 0, stripos($this->version, ' '));
        } else if (stripos($this->ua, 'Safari') !== false) {
            $this->browser = 'Safari';
            $this->version = substr($this->ua, (stripos($this->ua, 'Version/') + 8));
            $this->version = substr($this->version, 0, stripos($this->version, ' '));
        }
    }

}
