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

namespace PopTest\Locale;

use Pop\Loader\Autoloader,
    Pop\Locale\Locale;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class LocaleTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        define('POP_DEFAULT_LANG', 'fr');
        $l = new Locale();
        $this->assertEquals('Ce champ est obligatoire.', $l->__('This field is required.'));
        $this->assertEquals('La valeur ne doit pas faire partie du 127.0.0 de sous-réseau.', $l->__('The value must not be part of the subnet %1.', '127.0.0'));
        $this->assertEquals('La valeur ne doit pas faire partie du 127.0.0 de sous-réseau.', $l->__('The value must not be part of the subnet %1.', array('127.0.0')));
        $this->assertEquals('fr', $l->getLanguage());
    }

    public function testFactory()
    {
        $l = Locale::factory('fr');
        $class = 'Pop\\Locale\\Locale';
        $this->assertInstanceOf('Pop\\Locale\\Locale', $l);
        $this->assertEquals('Ce champ est obligatoire.', $l->__('This field is required.'));
    }

    public function testLoadFileException()
    {
        $this->setExpectedException('Pop\\Locale\\Exception');
        $l = Locale::factory();
        $l->loadFile('bad.xml');
    }

    public function testE()
    {
        $l = new Locale();
        ob_start();
        $l->_e('This field is required.');
        $output = ob_get_clean();
        $this->assertEquals('Ce champ est obligatoire.', $output);
    }

    public function testGetLanguages()
    {
        $l = new Locale();
        $this->assertEquals(12, count($l->getLanguages()));
    }

}

