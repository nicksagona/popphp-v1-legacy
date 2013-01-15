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

namespace PopTest\Log;

use Pop\Loader\Autoloader,
    Pop\Log\Logger,
    Pop\Log\Writer\Db,
    Pop\Log\Writer\File,
    Pop\Log\Writer\Mail,
    Pop\Record\Record;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class Logs extends Record { }

Logs::setDb(\Pop\Db\Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')));

class LogTest extends \PHPUnit_Framework_TestCase
{

    public function testLogConstructor()
    {
        $l = new Logger(new File(__DIR__ . '/../tmp/app.log'));
        $l->addWriter(new File(__DIR__ . '/../tmp/app.csv'));
        $this->assertInstanceOf('Pop\Log\Logger', $l);
        $this->assertEquals(2, count($l->getWriters()));
    }

    public function testSetAndGetTimestamp()
    {
        $l = new Logger();
        $l->setTimestamp('Y-m-d');
        $this->assertEquals('Y-m-d', $l->getTimestamp());
    }

    public function testLog()
    {
        $l = new Logger(new File(__DIR__ . '/../tmp/app.log'));
        $l->log(Logger::EMERG, 'Test log message');
        $this->assertTrue(file_exists(__DIR__ . '/../tmp/app.log'));
        $this->assertGreaterThan(0, filesize(__DIR__ . '/../tmp/app.log'));
        unlink(__DIR__ . '/../tmp/app.log');
    }

    public function testEmerg()
    {
        $l = new Logger(new File(__DIR__ . '/../tmp/app.log'));
        $l->emerg('Test log message');
        $this->assertTrue(file_exists(__DIR__ . '/../tmp/app.log'));
        $this->assertGreaterThan(0, filesize(__DIR__ . '/../tmp/app.log'));
        unlink(__DIR__ . '/../tmp/app.log');
    }

    public function testAlert()
    {
        $l = new Logger(new File(__DIR__ . '/../tmp/app.log'));
        $l->alert('Test log message');
        $this->assertTrue(file_exists(__DIR__ . '/../tmp/app.log'));
        $this->assertGreaterThan(0, filesize(__DIR__ . '/../tmp/app.log'));
        unlink(__DIR__ . '/../tmp/app.log');
    }

    public function testCrit()
    {
        $l = new Logger(new File(__DIR__ . '/../tmp/app.log'));
        $l->crit('Test log message');
        $this->assertTrue(file_exists(__DIR__ . '/../tmp/app.log'));
        $this->assertGreaterThan(0, filesize(__DIR__ . '/../tmp/app.log'));
        unlink(__DIR__ . '/../tmp/app.log');
    }

    public function testErr()
    {
        $l = new Logger(new File(__DIR__ . '/../tmp/app.log'));
        $l->err('Test log message');
        $this->assertTrue(file_exists(__DIR__ . '/../tmp/app.log'));
        $this->assertGreaterThan(0, filesize(__DIR__ . '/../tmp/app.log'));
        unlink(__DIR__ . '/../tmp/app.log');
    }

    public function testWarn()
    {
        $l = new Logger(new File(__DIR__ . '/../tmp/app.log'));
        $l->warn('Test log message');
        $this->assertTrue(file_exists(__DIR__ . '/../tmp/app.log'));
        $this->assertGreaterThan(0, filesize(__DIR__ . '/../tmp/app.log'));
        unlink(__DIR__ . '/../tmp/app.log');
    }

    public function testNotice()
    {
        $l = new Logger(new File(__DIR__ . '/../tmp/app.csv'));
        $l->notice('Test log message');
        $this->assertTrue(file_exists(__DIR__ . '/../tmp/app.csv'));
        $this->assertGreaterThan(0, filesize(__DIR__ . '/../tmp/app.csv'));
        unlink(__DIR__ . '/../tmp/app.csv');
    }

    public function testInfo()
    {
        $l = new Logger(new File(__DIR__ . '/../tmp/app.tsv'));
        $l->info('Test log message');
        $this->assertTrue(file_exists(__DIR__ . '/../tmp/app.tsv'));
        $this->assertGreaterThan(0, filesize(__DIR__ . '/../tmp/app.tsv'));
        unlink(__DIR__ . '/../tmp/app.tsv');
    }

    public function testDebug()
    {
        $l = new Logger(new File(__DIR__ . '/../tmp/app.xml'));
        $l->debug('Test log message');
        $this->assertTrue(file_exists(__DIR__ . '/../tmp/app.xml'));
        $this->assertGreaterThan(0, filesize(__DIR__ . '/../tmp/app.xml'));
        unlink(__DIR__ . '/../tmp/app.xml');
    }

    public function testWriterDb()
    {
        $w = new Db(new Logs());
        $this->assertInstanceOf('Pop\Log\Writer\Db', $w);
        $l = new Logger($w);
        $l->debug('Test log message');
        $entries = Logs::findAll();
        $this->assertEquals(1, count($entries->rows));
        foreach ($entries->rows as $row) {
            $e = Logs::findById($row->id);
            if (isset($e->id)) {
                $e->delete();
            }
        }
    }

    public function testWriterMail()
    {
        $w = new Mail(array(
            'Bob Smith' => 'bob@smith.com',
            'bubba@smith.com'
        ));
        $this->assertInstanceOf('Pop\Log\Writer\Mail', $w);
    }

    public function testWriterMailEmptyException()
    {
        $this->setExpectedException('Pop\Log\Writer\Exception');
        $w = new Mail(array());
        $this->assertInstanceOf('Pop\Log\Writer\Mail', $w);
    }

}

