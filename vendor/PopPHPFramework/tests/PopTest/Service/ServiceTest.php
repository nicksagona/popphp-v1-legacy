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

namespace PopTest\Service;

use Pop\Loader\Autoloader,
    Pop\Service\Locator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Service\Locator', new Locator());
    }

    public function testConstructorException()
    {
        $this->setExpectedException('Pop\Service\Exception');
        $s = new Locator(array('service' => null));
    }

    public function testSetandGetServices()
    {
        $l = new Locator(array(
            'config' => array(
                'class'  => 'Pop\Config',
                'params' => array(array('test' => 123), true)
            ),
            'std' => array(
                'class'  => 'stdClass'
            ),
            'rgb' => array(
                'class'  => 'Pop\Color\Rgb',
                'params' => function() { return array(255, 0, 0); }
            ),
            'cmyk' => new \Pop\Color\Cmyk(100, 0, 0, 50),
            'color' => function($locator) {
                return new \Pop\Color\Color($locator->get('rgb'));
            }
        ));
        $this->assertInstanceOf('Pop\Config', $l->get('config'));
        $this->assertInstanceOf('stdClass', $l->get('std'));
        $this->assertInstanceOf('Pop\Color\Rgb', $l->get('rgb'));
        $this->assertInstanceOf('Pop\Color\Cmyk', $l->get('cmyk'));
        $this->assertInstanceOf('Pop\Color\Color', $l->get('color'));
    }

    public function testRemove()
    {
        $l = new Locator(array(
            'config' => array(
                'class'  => 'Pop\Config',
                'params' => array(array('test' => 123), true)
            ),
            'rgb' => array(
                'class'  => 'Pop\Color\Rgb',
                'params' => function() { return array(255, 0, 0); }
            ),
            'color' => function($locator) {
                return new \Pop\Color\Color($locator->get('rgb'));
            }
        ));
        $c = $l->get('config');
        $l->remove('config');
        $this->assertInstanceOf('Pop\Config', $c);
        $this->assertNull($l->get('config'));
    }

    public function testGetNull()
    {
        $s = new Locator();
        $this->assertNull($s->get('service'));
    }

}

