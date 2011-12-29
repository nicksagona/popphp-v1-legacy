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
 * @package    Pop_Version
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop;

/**
 * @category   Pop
 * @package    Pop_Version
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Version
{

    /**
     * Current version
     */
    const VERSION = '0.9';

    /**
     * Current URL
     */
    const URL = 'http://www.popphp.org/version.txt';

    /**
     * Return plain text string
     */
    const PLAIN = 1;

    /**
     * Return html formatted string
     */
    const HTML = 2;

    /**
     * Return the data as a PHP array
     */
    const DATA = 3;

    /**
     * Returns the version of this library install.
     *
     * @return string
     */
    public static function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Returns the version of this library install.
     *
     * @param  string $ver
     * @return int
     */
    public static function compareVersion($ver)
    {
        return version_compare($ver, self::VERSION);
    }

    /**
     * Returns the latest version available.
     *
     * @return string|null
     */
    public static function getLatest()
    {
        $latest = null;

        $handle = fopen(self::URL, 'r');
        if ($handle !== false) {
            $latest = stream_get_contents($handle);
            fclose($handle);
        }

        return $latest;
    }

    /**
     * Returns an output of dependencies
     *
     * @param int $ret
     * @return string|array
     */
    public static function check($ret = Version::PLAIN)
    {
        // Get include path and define some variables.
        $includePath = explode(PATH_SEPARATOR, get_include_path());
        $php = array();
        $check = array();

        // PHP Version
        $php['Required PHP'] = '5.3.0';
        $php['Installed PHP'] = PHP_VERSION;

        // Archive
        $check['Archive Tar'] = 'No';
        foreach ($includePath as $path) {
            if (file_exists($path . DIRECTORY_SEPARATOR . 'Archive' . DIRECTORY_SEPARATOR . 'Tar.php')) {
                $check['Archive Tar'] = 'Yes';
            }
        }
        $check['Archive Phar'] = (!class_exists('Phar', false)) ? 'No' : 'Yes';
        $check['Archive Rar'] = (!class_exists('RarArchive', false)) ? 'No' : 'Yes';
        $check['Archive Zip'] = (!class_exists('ZipArchive', false)) ? 'No' : 'Yes';

        // Compress
        $check['Compress Bzip2'] = (function_exists('bzcompress'))  ? 'Yes' : 'No';
        $check['Compress Lzf'] = (function_exists('lzf_compress'))  ? 'Yes' : 'No';
        $check['Compress Zlib'] = (function_exists('gzcompress'))  ? 'Yes' : 'No';

        // cURL
        $check['cURL'] = (function_exists('curl_init'))  ? 'Yes' : 'No';

        // DB
        $check['Db MySql'] = (function_exists('mysql_connect'))  ? 'Yes' : 'No';
        $check['Db MySqli'] = (class_exists('mysqli')) ? 'Yes' : 'No';
        $check['Db Pdo'] = (class_exists('Pdo', false))  ? 'Yes' : 'No';
        $check['Db PgSql'] = (function_exists('pg_connect'))  ? 'Yes' : 'No';
        $check['Db Sqlite'] = (class_exists('Sqlite3', false))  ? 'Yes' : 'No';

        // DOM/XML
        $check['Dom DOMDocument'] = (class_exists('DOMDocument', false))  ? 'Yes' : 'No';
        $check['Dom SimpleXml'] = (class_exists('SimpleXMLElement', false))  ? 'Yes' : 'No';

        // FTP
        $check['FTP'] = (function_exists('ftp_connect'))  ? 'Yes' : 'No';

        // GeoIP
        if (function_exists('geoip_db_get_all_info')) {
            $yes = 'Yes';
            $databases = geoip_db_get_all_info();
            $count = 0;
            foreach ($databases as $db) {
                if ($db['available']) {
                    $count++;
                }
            }
            $check['GeoIP'] = $yes . ' (' . $count . '/' . count($databases) . ' GeoIP DBs Available)';
        } else {
            $check['GeoIP'] = 'No';
        }

        // Image
        $check['Image Gd'] = (function_exists('getimagesize'))  ? 'Yes' : 'No';
        $check['Image Freetype'] = (function_exists('imagettftext'))  ? 'Yes' : 'No';
        $check['Image Imagick'] = (class_exists('Imagick', false))  ? 'Yes' : 'No';

        // Memcache
        $check['Memcache'] = (class_exists('Memcache', false))  ? 'Yes' : 'No';

        // Total
        $count = array_count_values($check);
        $total = count($check) - $count['No'] . ' of ' . count($check);

        $results = null;
        $versionCompare = version_compare($php['Installed PHP'], $php['Required PHP']);

        // Format and return the results
        switch ($ret) {
            case self::PLAIN:
                foreach ($php as $key => $value) {
                    if ($key == 'Required PHP') {
                        $value = "\033[1;33m" . $value . "\033[0m";
                    } else {
                        $value = ($versionCompare < 0) ? "\033[1;31m" . $value . "\033[0m" : "\033[1;32m" . $value . "\033[0m";
                    }
                    $results .= $key . ': ' . $value . PHP_EOL;
                }
                $results .= '------------------' . PHP_EOL;
                foreach ($check as $key => $value) {
                    $value = (stripos($value, 'Yes') !== false) ? "\033[1;32m" . $value . "\033[0m" : "\033[1;31m" . $value . "\033[0m";
                    $results .= $key . ': ' . $value . PHP_EOL;
                }
                $results .= '------------------' . PHP_EOL;
                $results .= "Total: \033[1;34m" . $total . "\033[0m" . PHP_EOL;
                break;
            case self::HTML:
                foreach ($php as $key => $value) {
                    if ($key == 'Required PHP') {
                        $color = 'orange';
                    } else {
                        $color = ($versionCompare < 0) ? 'red' : 'green';
                    }
                    $results .= $key . ': <strong style="color: ' . $color . ';">' . $value . '</strong><br />' . PHP_EOL;
                }
                $results .= '<hr />' . PHP_EOL;
                foreach ($check as $key => $value) {
                    $color = ($value == 'No') ? 'red' : 'green';
                    $results .= $key . ': <strong style="color: ' . $color . ';">' . $value . '</strong><br />' . PHP_EOL;
                }
                $results .= '<hr />' . PHP_EOL;
                $results .= 'Total: <strong style="color: blue;">' . $total . '</strong>' . PHP_EOL;
                break;
            case self::DATA:
                $data = array();
                foreach ($php as $key => $value) {
                    if (strpos($key, ' ') !== false) {
                        $k = str_replace(' ', '', $key);
                        $k = strtolower(substr($k, 0, 1)) . substr($k, 1);
                    } else {
                        $k = strtolower($key);
                    }
                    $data[$k] = $value;
                }
                foreach ($check as $key => $value) {
                    if (strpos($key, ' ') !== false) {
                        $k = str_replace(' ', '', $key);
                        $k = strtolower(substr($k, 0, 1)) . substr($k, 1);
                    } else {
                        $k = strtolower($key);
                    }
                    $data[$k] = $value;
                }
                $results = new \ArrayObject($data, \ArrayObject::ARRAY_AS_PROPS);
                break;
        }

        return $results;
    }

}
