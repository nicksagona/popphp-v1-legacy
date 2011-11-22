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
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

require_once dirname(__FILE__) . '/../../library/Pop/Autoloader.php';
Pop_Autoloader::bootstrap();

class Pop_DbTest extends PHPUnit_Framework_TestCase
{

    public function testDbGetInstance()
    {
        $d = Pop_Db::getInstance('MySQLi', 'testdb', 'localhost', 'testuser', '12test34');
        $class = 'Pop_Db';
        $this->assertTrue($d instanceof $class);
    }

    public function testDbQueryAndFetch()
    {
        $d = Pop_Db::getInstance('MySQLi', 'testdb', 'localhost', 'testuser', '12test34');
        $d->interface->query('SELECT email FROM users WHERE user_id = 1');

        while (($row = $d->interface->fetch()) != false) {
            $email = $row['email'];
        }

        $this->assertEquals('test1@test.com', $email);
    }

    public function testDbLastId()
    {
        $d = Pop_Db::getInstance('MySQLi', 'testdb', 'localhost', 'testuser', '12test34');
        $d->interface->query("INSERT INTO users SET username = 'test2', email = 'test2@test.com'");
        $this->assertEquals(9, $d->interface->lastId());
    }

    public function testDbNumRows()
    {
        $d = Pop_Db::getInstance('MySQLi', 'testdb', 'localhost', 'testuser', '12test34');
        $d->interface->query('SELECT email FROM users WHERE user_id = 1');
        $this->assertEquals(1, $d->interface->numRows());
    }

    public function testDbNumFields()
    {
        $d = Pop_Db::getInstance('MySQLi', 'testdb', 'localhost', 'testuser', '12test34');
        $d->interface->query('SELECT * FROM users');
        $this->assertEquals(3, $d->interface->numFields());
    }

    public function testDbVersion()
    {
        $d = Pop_Db::getInstance('MySQLi', 'testdb', 'localhost', 'testuser', '12test34');
        $this->assertNotEquals(null, $d->interface->version());
    }

}

?>