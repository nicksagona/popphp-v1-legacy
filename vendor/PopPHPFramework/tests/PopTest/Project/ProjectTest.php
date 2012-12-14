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

namespace PopTest\Project;

use Pop\Loader\Autoloader,
    Pop\Db\Db,
    Pop\Mvc\Controller,
    Pop\Mvc\Router,
    Pop\Project\Project,
    Pop\Config;

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

}

