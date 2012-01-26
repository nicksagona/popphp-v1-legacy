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
 * @package    Pop_Geo
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Geo;

/**
 * @category   Pop
 * @package    Pop_Geo
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Geo
{

    /**
     * Host name to look up
     * @var string
     */
    protected $_host = null;

    /**
     * Host info
     * @var array
     */
    protected $_hostInfo = array(
        'areaCode'      => null,
        'city'          => null,
        'continentCode' => null,
        'country'       => null,
        'countryCode'   => null,
        'countryCode3'  => null,
        'dmaCode'       => null,
        'isp'           => null,
        'latitude'      => null,
        'longitude'     => null,
        'org'           => null,
        'postalCode'    => null,
        'region'        => null,
        'netspeed'      => null,
    );

    /**
     * Array of available databases
     * @var string
     */
    protected $_databases = array(
        'asnum'      => false,
        'city'       => false,
        'country'    => false,
        'countryv6'  => false,
        'domainname' => false,
        'isp'        => false,
        'netspeed'   => false,
        'org'        => false,
        'proxy'      => false,
        'region'     => false
    );

    /**
     * Constructor
     *
     * Instantiate the Geo object.
     *
     * @param  string $host
     * @return void
     */
    public function __construct($host = null)
    {
        $this->_host = (null === $host) ? $_SERVER['REMOTE_ADDR'] : $host;
        $this->_getAvailableDatabases();
        $this->_getHostInfo();
    }

    /**
     * Get an available database
     *
     * @param  string $name
     * @return boolean
     */
    public function isDbAvailable($name)
    {
        $key = strtolower($name);
        if (array_key_exists($key, $this->_databases)) {
            return $this->_databases[$key];
        } else {
            return false;
        }
    }

    /**
     * Get all available databases
     *
     * @return array
     */
    public function getDatabases()
    {
        return $this->_databases;
    }

    /**
     * Get host info
     *
     * @return array
     */
    public function getHostInfo()
    {
        return $this->_hostInfo;
    }

    /**
     * Get distance from current Geo object coordinates to another
     *
     * @param  float|Pop\Geo\Geo $latitude
     * @param  float             $longitude
     * @param  int               $round
     * @return float
     */
    public function distanceTo($latitude, $longitude = null, $round = 2)
    {
        $distance = null;

        // If a Geo object is passed
        if ($latitude instanceof Geo) {
            $geo = $latitude;
            $round = (null !== $longitude) ? (int)$longitude : 2;
            $latitude = (null !== $geo->latitude) ? $geo->latitude : null;
            $longitude = (null !== $geo->longitude) ? $geo->longitude : null;
        } else if (null === $longitude) {
            throw new Exception('You must either pass a Pop\\Geo\\Geo object or a set of latitude/longitude coordinates.');
        }

        // Calculate approximate distance between the two points in miles
        if ((null !== $this->_hostInfo['latitude']) && (null !== $this->_hostInfo['longitude'])
             && (null !== $latitude) && (null !== $longitude)) {
            $distance = (acos(
                sin($this->_hostInfo['latitude'] * pi() / 180)
                * sin($latitude * pi() / 180)
                + cos($this->_hostInfo['latitude'] * pi() / 180)
                * cos($latitude * pi() / 180)
                * cos(($this->_hostInfo['longitude'] - $longitude) * pi() / 180)
                ) * 180 / pi()
            ) * 60 * 1.1515;
            $distance = abs(round($distance, $round));
        }

        return $distance;
    }

    /**
     * Get method to return the value of _hostInfo[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return (array_key_exists($name, $this->_hostInfo)) ? $this->_hostInfo[$name] : null;
    }

    /**
     * Get available databases
     *
     * @return void
     */
    protected function _getAvailableDatabases()
    {
        $databases = geoip_db_get_all_info();

        foreach ($databases as $db) {
            if ((stripos($db['description'], 'ASNum') !== false) && ($db['available'])) {
                $this->_databases['asnum'] = true;
            }
            if ((stripos($db['description'], 'City') !== false) && ($db['available'])) {
                $this->_databases['city'] = true;
            }
            if ((stripos($db['description'], 'Country') !== false) && ($db['available'])) {
                $this->_databases['country'] = true;
            }
            if ((stripos($db['description'], 'Country V6') !== false) && ($db['available'])) {
                $this->_databases['countryv6'] = true;
            }
            if ((stripos($db['description'], 'Domain Name') !== false) && ($db['available'])) {
                $this->_databases['domainname'] = true;
            }
            if ((stripos($db['description'], 'ISP') !== false) && ($db['available'])) {
                $this->_databases['isp'] = true;
            }
            if ((stripos($db['description'], 'Netspeed') !== false) && ($db['available'])) {
                $this->_databases['netspeed'] = true;
            }
            if ((stripos($db['description'], 'Organization') !== false) && ($db['available'])) {
                $this->_databases['org'] = true;
            }
            if ((stripos($db['description'], 'Proxy') !== false) && ($db['available'])) {
                $this->_databases['proxy'] = true;
            }
            if ((stripos($db['description'], 'Region') !== false) && ($db['available'])) {
                $this->_databases['region'] = true;
            }
        }
    }

    /**
     * Get host information
     *
     * @return void
     */
    protected function _getHostInfo()
    {
        // Get base info by city
        if ($this->_databases['city']) {
            $data = geoip_record_by_name($this->_host);
            $this->_hostInfo['areaCode'] = $data['area_code'];
            $this->_hostInfo['city'] = $data['city'];
            $this->_hostInfo['continentCode'] = $data['continent_code'];
            $this->_hostInfo['country'] = $data['country_name'];
            $this->_hostInfo['countryCode'] = $data['country_code'];
            $this->_hostInfo['countryCode3'] = $data['country_code3'];
            $this->_hostInfo['dmaCode'] = $data['dma_code'];
            $this->_hostInfo['latitude'] = $data['latitude'];
            $this->_hostInfo['longitude'] = $data['longitude'];
            $this->_hostInfo['postalCode'] = $data['postal_code'];
            $this->_hostInfo['region'] = $data['region'];
        // Else, get base info by country
        } else if ($this->_databases['country']) {
            $this->_hostInfo['continentCode'] = geoip_continent_code_by_name($this->_host);
            $this->_hostInfo['country'] = geoip_country_name_by_name($this->_host);
            $this->_hostInfo['countryCode'] = geoip_country_code_by_name($this->_host);
            $this->_hostInfo['countryCode3'] = geoip_country_code3_by_name($this->_host);
        }

        // If available, get ISP name
        if ($this->_databases['isp']) {
            $this->_hostInfo['isp'] = geoip_isp_by_name($this->_host);
        }

        // If available, get internet connection speed
        if ($this->_databases['netspeed']) {
            $netspeed = geoip_id_by_name($this->_host);
            switch ($netspeed) {
                case GEOIP_DIALUP_SPEED:
                    $this->_hostInfo['netspeed'] = 'Dial-Up';
                    break;
                case GEOIP_CABLEDSL_SPEED:
                    $this->_hostInfo['netspeed'] = 'Cable/DSL';
                    break;
                case GEOIP_CORPORATE_SPEED:
                    $this->_hostInfo['netspeed'] = 'Corporate';
                    break;
                default:
                    $this->_hostInfo['netspeed'] = 'Unknown';
            }
        }

        // If available, get Organization name
        if ($this->_databases['org']) {
            $this->_hostInfo['org'] = geoip_org_by_name($this->_host);
        }
    }
}
