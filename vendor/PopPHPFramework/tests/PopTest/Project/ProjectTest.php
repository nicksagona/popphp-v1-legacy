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
namespace PopTest\Project;

use Pop\Loader\Autoloader;
use Pop\Db\Db;
use Pop\Mvc\Controller;
use Pop\Mvc\Router;
use Pop\Project\Project;
use Pop\Config;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ProjectTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $p = new Project(
            new Config(array(
                'databases' => array(
                    'testdb' => Db::factory('Sqlite', array (
                        'database' => __DIR__ . '/../tmp/test.sqlite'
                    ))
                ),

                'defaultDb' => 'testdb'
            )),
            array('Test' => new Config(array('some' => 'thing'))),
            new Router(array('Pop\Mvc\Controller' => new Controller()))
        );
        $p->run();
        $this->assertInstanceOf('Pop\Project\Project', $p);
    }

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\Project\Project', Project::factory(new Config(array())));
    }

    public function testDatabase()
    {
        $p = new Project(
            new Config(array(
                'databases' => array(
                    'testdb' => Db::factory('Sqlite', array (
                        'database' => __DIR__ . '/../tmp/test.sqlite'
                    ))
                ),

                'defaultDb' => 'testdb'
            )),
            array('Test' => new Config(array('some' => 'thing'))),
            new Router(array('Pop\Mvc\Controller' => new Controller()))
        );
        $this->assertInstanceOf('Pop\Db\Db', $p->database('testdb'));
        $this->assertNull($p->database('baddb'));
    }

    public function testModule()
    {
        $p = new Project(
            new Config(array(
                'databases' => array(
                    'testdb' => Db::factory('Sqlite', array (
                        'database' => __DIR__ . '/../tmp/test.sqlite'
                    ))
                ),

                'defaultDb' => 'testdb'
            )),
            array('Test' => new Config(array('some' => 'thing'))),
            new Router(array('Pop\Mvc\Controller' => new Controller()))
        );
        $this->assertInstanceOf('Pop\Config', $p->module('Test'));
        $this->assertTrue($p->isLoaded('Test'));
        $this->assertTrue(is_array($p->modules()));
        $this->assertEquals(1, count($p->modules()));
        $this->assertNull($p->module('BadModule'));
    }

    public function testRouter()
    {
        $p = new Project(
            new Config(array(
                'databases' => array(
                    'testdb' => Db::factory('Sqlite', array (
                        'database' => __DIR__ . '/../tmp/test.sqlite'
                    ))
                ),

                'defaultDb' => 'testdb'
            )),
            array('Test' => new Config(array('some' => 'thing'))),
            new Router(array('Pop\Mvc\Controller' => new Controller()))
        );
        $this->assertInstanceOf('Pop\Mvc\Router', $p->router());
    }

    public function testLoadConfig()
    {
        $p = new Project();
        $p->loadConfig(
            new Config(array(
                'databases' => array(
                    'testdb' => Db::factory('Sqlite', array (
                        'database' => __DIR__ . '/../tmp/test.sqlite'
                    ))
                ),

                'defaultDb' => 'testdb'
            ))
        );
        $this->assertInstanceOf('Pop\Config', $p->config());

        $p = new Project();
        $p->loadConfig(
            array(
                'databases' => array(
                    'testdb' => Db::factory('Sqlite', array (
                        'database' => __DIR__ . '/../tmp/test.sqlite'
                    ))
                ),

                'defaultDb' => 'testdb'
            )
        );
        $this->assertInstanceOf('Pop\Config', $p->config());
    }

    public function testLoadConfigException()
    {
        $this->setExpectedException('Pop\Project\Exception');
        $p = new Project();
        $p->loadConfig(
            new Config(array(
                'databases' => array(
                    'testdb' => Db::factory('Sqlite', array (
                        'database' => __DIR__ . '/../tmp/test.sqlite'
                    ))
                ),

                'defaultDb' => 'testdb'
            ))
        );
        $p->loadConfig(
            new Config(array(
                'databases' => array(
                    'testdb' => Db::factory('Sqlite', array (
                        'database' => __DIR__ . '/../tmp/test.sqlite'
                    ))
                ),

                'defaultDb' => 'testdb'
            ))
        );
    }

    public function testLoadConfigTypeExecption()
    {
        $this->setExpectedException('Pop\Project\Exception');
        $p = new Project();
        $p->loadConfig('bad config');
    }

    public function testLoadModule()
    {
        $p = new Project(
            new Config(array(
                'databases' => array(
                    'testdb' => Db::factory('Sqlite', array (
                        'database' => __DIR__ . '/../tmp/test.sqlite'
                    ))
                ),

                'defaultDb' => 'testdb'
            )),
            null,
            new Router(array('Pop\Mvc\Controller' => new Controller()))
        );
        $p->loadModule(array('Test' => new Config(array('some' => 'thing'))));
        $p->loadModule(array('Blah' => array('some' => 'thing')));
        $this->assertInstanceOf('Pop\Config', $p->module('Test'));
        $this->assertInstanceOf('Pop\Config', $p->module('Blah'));
    }

    public function testLoadModuleException()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $p = new Project(
            new Config(array(
                'databases' => array(
                    'testdb' => Db::factory('Sqlite', array (
                        'database' => __DIR__ . '/../tmp/test.sqlite'
                    ))
                ),

                'defaultDb' => 'testdb'
            )),
            null,
            new Router(array('Pop\Mvc\Controller' => new Controller()))
        );
        $p->loadModule(new Config());
    }

    public function testLoadModuleTypeException()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $p = new Project();
        $p->loadModule('bad config');
    }

    public function testLoadRouter()
    {
        $p = new Project(
            new Config(array(
                'databases' => array(
                    'testdb' => Db::factory('Sqlite', array (
                        'database' => __DIR__ . '/../tmp/test.sqlite'
                    ))
                ),

                'defaultDb' => 'testdb'
            )),
            array('Test' => new Config(array('some' => 'thing')))
        );
        $p->loadRouter(new Router(array('Pop\Mvc\Controller' => new Controller())));
        $this->assertInstanceOf('Pop\Mvc\Router', $p->router());
    }

    public function testEventManager()
    {
        $func = function() { return 'Hello World'; };
        $p = new Project();
        $p->attachEvent('route.pre', $func, 2);
        $this->assertEquals(1, count($p->getEventManager()->get('route.pre')));
        $p->detachEvent('route.pre', $func);
        $this->assertEquals(0, count($p->getEventManager()->get('route.pre')));
    }

    public function testServiceLocator()
    {
        $p = new Project();
        $p->setService('config', 'Pop\Config', array(array('test' => 123)))
          ->setService('color', 'Pop\Color\Color', function() {
            return array(new \Pop\Color\Space\Rgb(255, 0, 0));
        });
        $this->assertInstanceOf('Pop\Config', $p->getService('config'));
        $this->assertInstanceOf('Pop\Color\Color', $p->getService('color'));
        $this->assertInstanceOf('Pop\Service\Locator', $p->getServiceLocator());
    }

}

