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

namespace Pop;

use Pop\Loader\Autoloader,
    Pop\Filter\Search;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class SearchTest extends \PHPUnit_Framework_TestCase
{

    public function testSearch()
    {
        $s = Search::factory('1|2|3|4|5', '|');
        $class = 'Pop\\Filter\\Search';
        $r = $s->search('1');
        $this->assertTrue($s instanceof $class);
        $this->assertTrue(in_array('1', $r));
    }

}

