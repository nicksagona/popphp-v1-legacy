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
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Web;

/**
 * This is the Mobile class for the Web component.
 *
 * @category   Pop
 * @package    Pop_Web
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.1
 */
class Mobile
{

    /**
     * Constant to force standard display
     * @var int
     */
    const FORCE_STANDARD = 1;

    /**
     * Constant to force mobile display
     * @var int
     */
    const FORCE_MOBILE = 2;

    /**
     * User agent property
     * @var string
     */
    protected $ua = null;

    /**
     * Mobile Device
     * @var string
     */
    protected $device = null;

    /**
     * Standard website destination URL
     * @var string
     */
    protected $standard = null;

    /**
     * Mobile website destination URL
     * @var string
     */
    protected $mobile = null;

    /**
     * Force flag
     * @var int
     */
    protected $force = 0;

    /**
     * Mobile detect
     * @var boolean
     */
    protected $isMobile = false;

    /**
     * Constructor
     *
     * Instantiate the mobile session object.
     *
     * @param  string $mobile
     * @param  string $full
     * @param  int    $force
     * @return \Pop\Web\Mobile
     */
    public function __construct($mobile = null, $full = null, $force = 0)
    {
        // Set the user agent and object properties.
        $this->ua = $_SERVER['HTTP_USER_AGENT'];
        $this->mobile = $mobile;
        $this->standard = $full;
        $this->isMobile = $this->detect();
        $this->force = $force;
    }

    /**
     * Static method to only detect a mobile device or not.
     *
     * @return boolean
     */
    public static function isMobileDevice()
    {
        $mob = new static();
        return $mob->isMobile;
    }

    /**
     * Static method to only get the mobile device.
     *
     * @return string
     */
    public static function getMobileDevice()
    {
        $mob = new static();
        return $mob->device;
    }

    /**
     * Method to go to the mobile site.
     *
     * @throws Exception
     * @return void
     */
    public function goToMobile()
    {
        if (null === $this->mobile) {
            throw new Exception('The mobile site is not set.');
        }
        header("HTTP/1.1 302 Found");
        header("Location: " . $this->mobile);
    }

    /**
     * Method to go to the standard site.
     *
     * @throws Exception
     * @return void
     */
    public function goToStandard()
    {
        if (null === $this->standard) {
            throw new Exception('The standard site is not set.');
        }
        header("HTTP/1.1 302 Found");
        header("Location: " . $this->standard);
    }

    /**
     * Method to go to a specific URL.
     *
     * @param  string $url
     * @return void
     */
    public function goToURL($url)
    {
        header("HTTP/1.1 302 Found");
        header("Location: " . $url);
    }

    /**
     * Method to route to the appropriate URL
     *
     * @return void
     */
    public function route()
    {
        switch ($this->force) {
            case 0:
                if ($this->isMobile) {
                    $this->goToMobile();
                } else {
                    $this->goToStandard();
                }
                break;

            case 1:
                $this->goToStandard();
                break;

            case 2:
                $this->goToMobile();
                break;
        }
    }

    /**
     * Method to get user-agent
     *
     * @return string
     */
    public function getUa()
    {
        return $this->ua;
    }

    /**
     * Method to get device name
     *
     * @return string
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Method to get standard URL
     *
     * @return string
     */
    public function getStandardUrl()
    {
        return $this->standard;
    }

    /**
     * Method to get mobile URL
     *
     * @return string
     */
    public function getMobileUrl()
    {
        return $this->mobile;
    }

    /**
     * Method to get force flag
     *
     * @return int
     */
    public function getForce()
    {
        return $this->force;
    }

    /**
     * Method to get is mobile flag
     *
     * @return boolean
     */
    public function isMobile()
    {
        return $this->isMobile;
    }

    /**
     * Method to detect whether or not the device is a mobile device or not.
     *
     * @return boolean
     */
    protected function detect()
    {
        $matches = array();
        $is = false;

        // Android devices
        if (stripos($this->ua, 'android') !== false) {
            $this->device = 'Android';
            $is = true;
        // Blackberry devices
        } else if (stripos($this->ua, 'blackberry') !== false) {
            $this->device = 'Blackberry';
            $is = true;
        // Windows devices
        } else if ((stripos($this->ua, 'windows ce') !== false) || (stripos($this->ua, 'windows phone') !== false)) {
            $this->device = 'Windows';
            $is = true;
        // Opera devices
        } else if (stripos($this->ua, 'opera mini') !== false) {
            $this->device = 'Opera';
            $is = true;
        // Palm Pre devices
        } else if ((stripos($this->ua, 'pre') !== false) && (stripos($this->ua, 'presto') === false)) {
            $this->device = 'Pre';
            $is = true;
        // Apple devices
        } else if (preg_match('/(ipod|iphone|ipad)/i', $this->ua, $matches) != 0) {
            $this->device = $matches[0];
            $is = true;
        // Nokia and other devices
        } else if (preg_match('/(nokia|symbian|palm|treo|hiptop|avantgo|plucker|xiino|blazer|elaine|teleca|up.browser|up.link|mmp|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|pda|psp)/i', $this->ua, $matches) != 0) {
            $this->device = $matches[0];
            $is = true;
        }

        return $is;
    }

}
