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
 * @package    Pop_Mobile
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_Mobile
 *
 * @category   Pop
 * @package    Pop_Mobile
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Mobile
{

    /**
     * User agent property
     * @var string
     */
    public $ua = null;

    /**
     * Mobile Device
     * @var string
     */
    public $device = null;

    /**
     * Standard website destination
     * @var string
     */
    public $standard = null;

    /**
     * Mobile website destination
     * @var string
     */
    public $mobile = null;

    /**
     * Mobile detect
     * @var boolean
     */
    public $isMobile = false;

    /**
     * Mobile bypass flag
     * @var string
     */
    public $bypass = null;

    /**
     * Constructor
     *
     * Instantiate the mobile session object.
     *
     * @param  string $mobile
     * @param  string $full
     * @return void
     */
    public function __construct($mobile = null, $full = null)
    {
        // Set the user agent and object properties.
        $this->ua = $_SERVER['HTTP_USER_AGENT'];
        $this->mobile = $mobile;
        $this->standard = $full;
        $this->isMobile = $this->_detect();

        $sess = Pop_Session::getInstance();

        if (isset($sess->pop_mobile_bypass)) {
            $this->bypass = $sess->pop_mobile_bypass;
        }
    }

    /**
     * Method to go to the mobile site.
     *
     * @throws Exception
     * @return void
     */
    public function goToMobile()
    {
        if (is_null($this->mobile)) {
            throw new Exception(Pop_Locale::load()->__('The mobile site is not set.'));
        } else {
            Pop_Http_Response::redirect($this->mobile);
        }
    }

    /**
     * Method to go to the standard site.
     *
     * @throws Exception
     * @return void
     */
    public function goToStandard()
    {
        if (is_null($this->standard)) {
            throw new Exception(Pop_Locale::load()->__('The standard site is not set.'));
        } else {
            Pop_Http_Response::redirect($this->standard);
        }
    }

    /**
     * Method to go to a specific URL.
     *
     * @param  string $url
     * @return void
     */
    public function goToURL($url)
    {
        Pop_Http_Response::redirect($url);
    }

    /**
     * Method to detect whether or not the device is a mobile device or not.
     *
     * @return boolean
     */
    protected function _detect()
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
        } else if (preg_match('/(ipod|iphone)/i', $this->ua, $matches) != 0) {
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
