<?php
/**
 * Pop PHP Framework Unit Tests (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Test
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace PopTest\Form;

use Pop\Loader\Autoloader;
use Pop\Db\Db;
use Pop\Form\Fields;
use Pop\Db\Record;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class Users extends Record {
    protected $usePrepared = true;
}

class FieldsTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Form\Fields', new Fields());
    }

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\Form\Fields', Fields::factory());
    }

    public function testAddAndGetFields()
    {
        $fields = array(
            'username' => array(
                'type'       => 'text',
                'value'      => 'Username here...',
                'label'      => 'Username:',
                'required'   => true,
                'attributes' => array('size' => 40)
            )
        );
        $f = new Fields($fields);
        $f->addFields(array(
            'submit' => array(
                'type' => 'submit',
                'value' => 'SUBMIT'
            )
        ));
        $this->assertEquals(2, count($f->getFields()));
    }

    public function testAddAndGetFieldsFromTable()
    {
        Users::setDb(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')));
        $f = Fields::factory(Users::getTableInfo());
        $f = Fields::factory(Users::getTableInfo(), array('size' => 40), array('id' => array('type' => 'hidden')), array('access'));
        $f = Fields::factory(Users::getTableInfo(), array('size' => 40), array('id' => array('type' => 'hidden')), 'access');
        $this->assertEquals(4, count($f->getFields()));
        $this->assertEquals('Username:', $f->username['label']);
        $f->username = array(
            'type'       => 'text',
            'value'      => 'Username here...',
            'label'      => 'New Username:',
            'required'   => true,
            'attributes' => array('size' => 40)
        );
        $this->assertTrue(isset($f->username));
        $this->assertEquals('New Username:', $f->username['label']);
        $f->setField('username', 'label', 'Other Username:');
        $this->assertEquals('Other Username:', $f->username['label']);
        $f->setField('username', array('label' => 'Another Username:'));
        $this->assertEquals('Another Username:', $f->username['label']);
        unset($f->username);
        $this->assertFalse(isset($f->username));
    }

    public function testAddFieldsFromTableException()
    {
        $this->setExpectedException('Pop\Form\Exception');
        Users::setDb(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')));
        $f = Fields::factory(array());
        $f->addFieldsFromTable(array());
    }

}

