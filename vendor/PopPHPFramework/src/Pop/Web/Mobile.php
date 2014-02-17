<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Web
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Web;

/**
 * Mobile class
 *
 * @category   Pop
 * @package    Pop_Web
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Mobile
{

    /**
     * Constant to force desktop display
     * @var int
     */
    const DESKTOP = 1;

    /**
     * Constant to force mobile display
     * @var int
     */
    const MOBILE = 2;

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
     * Desktop website destination URL
     * @var string
     */
    protected $desktopUrl = null;

    /**
     * Mobile website destination URL
     * @var string
     */
    protected $mobileUrl = null;

    /**
     * Force flag
     * @var int
     */
    protected $force = 0;

    /**
     * Mobile detect flag
     * @var boolean
     */
    protected $mobile = false;

    /**
     * Tablet detect flag
     * @var boolean
     */
    protected $tablet = false;

    /**
     * Android flag
     * @var boolean
     */
    protected $android = false;

    /**
     * Apple flag
     * @var boolean
     */
    protected $apple = false;

    /**
     * Windows flag
     * @var boolean
     */
    protected $windows = false;

    /**
     * Blackberry flag
     * @var boolean
     */
    protected $blackberry = false;

    /**
     * Pre flag
     * @var boolean
     */
    protected $pre = false;

    /**
     * Opera flag
     * @var boolean
     */
    protected $opera = false;

    /**
     * Constructor
     *
     * Instantiate the mobile session object.
     *
     * @param  string $mobile
     * @param  string $desktop
     * @param  int    $force
     * @return \Pop\Web\Mobile
     */
    public function __construct($mobile = null, $desktop = null, $force = 0)
    {
        // Set the user agent and object properties.
        $this->ua = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : null;
        $this->mobileUrl = $mobile;
        $this->desktopUrl = $desktop;
        $this->mobile = $this->detect();
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
        return $mob->isMobile();
    }

    /**
     * Static method to only detect a tablet device or not.
     *
     * @return boolean
     */
    public static function isTabletDevice()
    {
        $mob = new static();
        return $mob->isTablet();
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
     * Method to get desktop URL
     *
     * @return string
     */
    public function getDesktopUrl()
    {
        return $this->desktopUrl;
    }

    /**
     * Method to get mobile URL
     *
     * @return string
     */
    public function getMobileUrl()
    {
        return $this->mobileUrl;
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
     * Method to set desktop URL
     *
     * @param string $url
     * @return \Pop\Web\Mobile
     */
    public function setDesktopUrl($url)
    {
        $this->desktopUrl = $url;
        return $this;
    }

    /**
     * Method to set mobile URL
     *
     * @param string $url
     * @return \Pop\Web\Mobile
     */
    public function setMobileUrl($url)
    {
        $this->mobileUrl = $url;
        return $this;
    }

    /**
     * Method to set force flag
     *
     * @param int $force
     * @return \Pop\Web\Mobile
     */
    public function setForce($force)
    {
        $this->force = (int)$force;
        return $this;
    }

    /**
     * Method to get is mobile flag
     *
     * @return boolean
     */
    public function isMobile()
    {
        return $this->mobile;
    }

    /**
     * Method to get is tablet flag
     *
     * @return boolean
     */
    public function isTablet()
    {
        return $this->tablet;
    }

    /**
     * Method to get Android flag
     *
     * @return boolean
     */
    public function isAndroid()
    {
        return $this->android;
    }

    /**
     * Method to get Apple flag
     *
     * @return boolean
     */
    public function isApple()
    {
        return $this->apple;
    }

    /**
     * Method to get Windows flag
     *
     * @return boolean
     */
    public function isWindows()
    {
        return $this->windows;
    }

    /**
     * Method to get Blackberry flag
     *
     * @return boolean
     */
    public function isBlackberry()
    {
        return $this->blackberry;
    }

    /**
     * Method to get Pre flag
     *
     * @return boolean
     */
    public function isPre()
    {
        return $this->pre;
    }

    /**
     * Method to get Opera flag
     *
     * @return boolean
     */
    public function isOpera()
    {
        return $this->opera;
    }

    /**
     * Method to go to the mobile site.
     *
     * @throws Exception
     * @return void
     */
    public function goToMobile()
    {
        if (null === $this->mobileUrl) {
            throw new Exception('The mobile site is not set.');
        }
        header("HTTP/1.1 302 Found");
        header("Location: " . $this->mobileUrl);
    }

    /**
     * Method to go to the desktop site.
     *
     * @throws Exception
     * @return void
     */
    public function goToDesktop()
    {
        if (null === $this->desktopUrl) {
            throw new Exception('The desktop site is not set.');
        }
        header("HTTP/1.1 302 Found");
        header("Location: " . $this->desktopUrl);
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
                if ($this->mobile) {
                    $this->goToMobile();
                } else {
                    $this->goToDesktop();
                }
                break;

            case 1:
                $this->goToDesktop();
                break;

            case 2:
                $this->goToMobile();
                break;
        }
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
            $this->android = true;
            $is = true;
        // Blackberry devices
        } else if (stripos($this->ua, 'blackberry') !== false) {
            $this->device = 'Blackberry';
            $this->blackberry = true;
            $is = true;
        // Windows devices
        } else if ((stripos($this->ua, 'windows ce') !== false) || (stripos($this->ua, 'windows phone') !== false)) {
            $this->device = 'Windows';
            $this->windows = true;
            $is = true;
        // Opera devices
        } else if (stripos($this->ua, 'opera mini') !== false) {
            $this->device = 'Opera';
            $this->opera = true;
            $is = true;
        // Palm Pre devices
        } else if ((stripos($this->ua, 'pre') !== false) && (stripos($this->ua, 'presto') === false)) {
            $this->device = 'Pre';
            $this->pre = true;
            $is = true;
        // Apple devices
        } else if (preg_match('/(ipod|iphone|ipad)/i', $this->ua, $matches) != 0) {
            $this->device = $matches[0];
            $this->apple = true;
            $is = true;
        // Other devices
        } else if (preg_match('/(nokia|symbian|palm|treo|hiptop|avantgo|plucker|xiino|blazer|elaine|teleca|up.browser|up.link|mmp|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|pda|psp)/i', $this->ua, $matches) != 0) {
            $this->device = $matches[0];
            $is = true;
        }

        if ($is) {
            if (strtolower($this->device) == 'ipad') {
                $this->tablet = true;
            } else {
                $this->tablet = (stripos($this->ua, 'mobile') !== false) ? false : true;
            }
        }

        return $is;
    }

}
