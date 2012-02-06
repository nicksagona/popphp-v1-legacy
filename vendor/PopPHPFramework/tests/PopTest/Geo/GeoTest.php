<?php
/**
 * Pop PHP Framework Unit Tests
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
 */

namespace PopTest\Geo;

use Pop\Loader\Autoloader,
    Pop\Geo\Geo;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class GeoTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        if (function_exists('geoip_db_get_all_info')) {
            $g = new Geo('www.google.com');
            $class = 'Pop\\Geo\\Geo';
            $this->assertTrue($g instanceof $class);
        }
    }

}

?>