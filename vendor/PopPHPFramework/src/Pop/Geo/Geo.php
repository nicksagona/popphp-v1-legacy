<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Geo
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Geo;

/**
 * Geo class
 *
 * @category   Pop
 * @package    Pop_Geo
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Geo
{

    /**
     * Host name to look up
     * @var string
     */
    protected $host = null;

    /**
     * Host info
     * @var array
     */
    protected $hostInfo = array(
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
    protected $databases = array(
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
     * @return \Pop\Geo\Geo
     */
    public function __construct($host = null)
    {
        $this->host = (null === $host) ? $_SERVER['REMOTE_ADDR'] : $host;
        $this->getAvailableDatabases();
        $this->getGeoIpHostInfo();
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
        if (array_key_exists($key, $this->databases)) {
            return $this->databases[$key];
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
        return $this->databases;
    }

    /**
     * Get host info
     *
     * @return array
     */
    public function getHostInfo()
    {
        return $this->hostInfo;
    }

    /**
     * Get distance from current Geo object coordinates to another
     *
     * @param  mixed     $latitude
     * @param  float     $longitude
     * @param  int       $round
     * @throws Exception
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
            throw new Exception('You must either pass a Pop\Geo\Geo object or a set of latitude/longitude coordinates.');
        }

        // Calculate approximate distance between the two points in miles
        if ((null !== $this->hostInfo['latitude']) && (null !== $this->hostInfo['longitude'])
             && (null !== $latitude) && (null !== $longitude)) {
            $distance = (acos(
                sin($this->hostInfo['latitude'] * pi() / 180)
                * sin($latitude * pi() / 180)
                + cos($this->hostInfo['latitude'] * pi() / 180)
                * cos($latitude * pi() / 180)
                * cos(($this->hostInfo['longitude'] - $longitude) * pi() / 180)
                ) * 180 / pi()
            ) * 60 * 1.1515;
            $distance = abs(round($distance, $round));
        }

        return $distance;
    }

    /**
     * Get method to return the value of hostInfo[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return (array_key_exists($name, $this->hostInfo)) ? $this->hostInfo[$name] : null;
    }

    /**
     * Get available databases
     *
     * @return void
     */
    protected function getAvailableDatabases()
    {
        $databases = geoip_db_get_all_info();

        foreach ($databases as $db) {
            if ((stripos($db['description'], 'ASNum') !== false) && ($db['available'])) {
                $this->databases['asnum'] = true;
            }
            if ((stripos($db['description'], 'City') !== false) && ($db['available'])) {
                $this->databases['city'] = true;
            }
            if ((stripos($db['description'], 'Country') !== false) && ($db['available'])) {
                $this->databases['country'] = true;
            }
            if ((stripos($db['description'], 'Country V6') !== false) && ($db['available'])) {
                $this->databases['countryv6'] = true;
            }
            if ((stripos($db['description'], 'Domain Name') !== false) && ($db['available'])) {
                $this->databases['domainname'] = true;
            }
            if ((stripos($db['description'], 'ISP') !== false) && ($db['available'])) {
                $this->databases['isp'] = true;
            }
            if ((stripos($db['description'], 'Netspeed') !== false) && ($db['available'])) {
                $this->databases['netspeed'] = true;
            }
            if ((stripos($db['description'], 'Organization') !== false) && ($db['available'])) {
                $this->databases['org'] = true;
            }
            if ((stripos($db['description'], 'Proxy') !== false) && ($db['available'])) {
                $this->databases['proxy'] = true;
            }
            if ((stripos($db['description'], 'Region') !== false) && ($db['available'])) {
                $this->databases['region'] = true;
            }
        }
    }

    /**
     * Get GeoIp host information
     *
     * @return void
     */
    protected function getGeoIpHostInfo()
    {
        // Get base info by city
        if ($this->databases['city']) {
            $data = geoip_record_by_name($this->host);
            $this->hostInfo['areaCode'] = $data['area_code'];
            $this->hostInfo['city'] = $data['city'];
            $this->hostInfo['continentCode'] = $data['continent_code'];
            $this->hostInfo['country'] = $data['country_name'];
            $this->hostInfo['countryCode'] = $data['country_code'];
            $this->hostInfo['countryCode3'] = $data['country_code3'];
            $this->hostInfo['dmaCode'] = $data['dma_code'];
            $this->hostInfo['latitude'] = $data['latitude'];
            $this->hostInfo['longitude'] = $data['longitude'];
            $this->hostInfo['postalCode'] = $data['postal_code'];
            $this->hostInfo['region'] = $data['region'];
        // Else, get base info by country
        } else if ($this->databases['country']) {
            $this->hostInfo['continentCode'] = geoip_continent_code_by_name($this->host);
            $this->hostInfo['country'] = geoip_country_name_by_name($this->host);
            $this->hostInfo['countryCode'] = geoip_country_code_by_name($this->host);
            $this->hostInfo['countryCode3'] = geoip_country_code3_by_name($this->host);
        }

        // If available, get ISP name
        if ($this->databases['isp']) {
            $this->hostInfo['isp'] = geoip_isp_by_name($this->host);
        }

        // If available, get internet connection speed
        if ($this->databases['netspeed']) {
            $netspeed = geoip_id_by_name($this->host);
            switch ($netspeed) {
                case GEOIP_DIALUP_SPEED:
                    $this->hostInfo['netspeed'] = 'Dial-Up';
                    break;
                case GEOIP_CABLEDSL_SPEED:
                    $this->hostInfo['netspeed'] = 'Cable/DSL';
                    break;
                case GEOIP_CORPORATE_SPEED:
                    $this->hostInfo['netspeed'] = 'Corporate';
                    break;
                default:
                    $this->hostInfo['netspeed'] = 'Unknown';
            }
        }

        // If available, get Organization name
        if ($this->databases['org']) {
            $this->hostInfo['org'] = geoip_org_by_name($this->host);
        }
    }
}
