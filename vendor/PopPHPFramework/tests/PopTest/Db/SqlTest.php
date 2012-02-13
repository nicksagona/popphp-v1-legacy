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

namespace PopTest\Db;

use Pop\Loader\Autoloader,
    Pop\Db\Sql;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class SqlTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $s = new Sql('users');
        $class = 'Pop\\Db\\Sql';
        $this->assertTrue($s instanceof $class);
    }

    public function testSql()
    {
        $s = new Sql('users');
        $s->setIdQuoteType(Sql::BACKTICK)
          ->select()
          ->where('id', '=', 1);
        $this->assertEquals('SELECT * FROM `users` WHERE (`id` = \'1\')', $s->getSql());
    }

}

