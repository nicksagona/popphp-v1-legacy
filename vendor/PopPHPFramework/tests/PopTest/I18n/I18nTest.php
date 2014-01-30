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
namespace PopTest\I18n;

use Pop\Loader\Autoloader;
use Pop\I18n\I18n;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class I18nTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        define('POP_LANG', 'fr_FR');
        $l = new I18n();
        $this->assertEquals('Ce champ est obligatoire.', $l->__('This field is required.'));
        $this->assertEquals('La valeur ne doit pas faire partie du 127.0.0 de sous-réseau.', $l->__('The value must not be part of the subnet %1.', '127.0.0'));
        $this->assertEquals('La valeur ne doit pas faire partie du 127.0.0 de sous-réseau.', $l->__('The value must not be part of the subnet %1.', array('127.0.0')));
        $this->assertEquals('fr', $l->getLanguage());
        $this->assertEquals('FR', $l->getLocale());
    }

    public function testFactory()
    {
        $l = I18n::factory('es_ES');
        $this->assertInstanceOf('Pop\I18n\I18n', $l);
        $this->assertEquals('Este campo es obligatorio.', $l->__('This field is required.'));
    }

    public function testLangNoLocale()
    {
        $l = I18n::factory('es');
        $this->assertInstanceOf('Pop\I18n\I18n', $l);
        $this->assertEquals('es', $l->getLanguage());
        $this->assertEquals('ES', $l->getLocale());
    }

    public function testLoadFileNoFileException()
    {
        $this->setExpectedException('Pop\I18n\Exception');
        $l = I18n::factory();
        $l->loadFile('bad.xml');
    }

    public function testLoadFileBadFileException()
    {
        $this->setExpectedException('Exception');
        $l = I18n::factory();
        $l->loadFile(__DIR__ . '/../tmp/access.txt');
    }

    public function testE()
    {
        $l = new I18n();
        ob_start();
        $l->_e('This field is required.');
        $output = ob_get_clean();
        $this->assertEquals('Ce champ est obligatoire.', $output);
    }

    public function testGetLanguages()
    {
        $this->assertEquals(12, count(I18n::getLanguages()));
    }

    public function testCreateXmlFile()
    {
        $lang = array(
            'src'    => 'en',
            'output' => 'de',
            'name'   => 'German',
            'native' => 'Deutsch'
        );

        $locales = array(
            array(
                'region' => 'DE',
                'name'   => 'Germany',
                'native' => 'Deutschland',
                'text' => array(
                    array(
                        'source' => 'This field is required.',
                        'output' => 'Dieses Feld ist erforderlich.'
                    ),
                    array(
                        'source' => 'Thursday',
                        'output' => 'Donnerstag'
                    ),
                    array(
                        'source' => 'The value length must be between or equal to %1 and %2.',
                        'output' => 'Der Wert muss zwischen oder gleich %1 und %2 sein.'
                    )
                )
            ),
            array(
                'region' => 'CH',
                'name'   => 'Switzerland',
                'native' => 'Schweiz',
                'text' => array(
                    array(
                        'source' => 'This field is required. (CH)',
                        'output' => 'Dieses Feld ist erforderlich. (CH)'
                    ),
                    array(
                        'source' => 'Thursday (CH)',
                        'output' => 'Donnerstag (CH)'
                    ),
                    array(
                        'source' => 'The value length must be between or equal to %1 and %2. (CH)',
                        'output' => 'Der Wert muss zwischen oder gleich %1 und %2 sein. (CH)'
                    )
                )
            )
        );

        I18n::createXmlFile($lang, $locales, __DIR__ . '/../tmp/new_de.xml');
        $this->assertFileExists(__DIR__ . '/../tmp/new_de.xml');
        if (file_exists(__DIR__ . '/../tmp/new_de.xml')) {
            unlink(__DIR__ . '/../tmp/new_de.xml');
        }
    }

    public function testCreateXmlFileNoSrcException()
    {
        $this->setExpectedException('Pop\I18n\Exception');
        $lang = array(
            'output' => 'de',
            'name'   => 'German',
            'native' => 'Deutsch'
        );

        $locales = array();

        I18n::createXmlFile($lang, $locales, __DIR__ . '/../tmp/new_de.xml');
    }

    public function testCreateXmlFileNoRegionException()
    {
        $this->setExpectedException('Pop\I18n\Exception');
        $lang = array(
            'src'    => 'en',
            'output' => 'de',
            'name'   => 'German',
            'native' => 'Deutsch'
        );

        $locales = array(
            array(
                'name'   => 'Germany',
                'native' => 'Deutschland',
                'text' => array(
                    array(
                        'source' => 'This field is required.',
                        'output' => 'Dieses Feld ist erforderlich.'
                    ),
                    array(
                        'source' => 'Thursday',
                        'output' => 'Donnerstag'
                    ),
                    array(
                        'source' => 'The value length must be between or equal to %1 and %2.',
                        'output' => 'Der Wert muss zwischen oder gleich %1 und %2 sein.'
                    )
                )
            )
        );

        I18n::createXmlFile($lang, $locales, __DIR__ . '/../tmp/new_de.xml');
    }

    public function testCreateXmlFileNoTextException()
    {
        $this->setExpectedException('Pop\I18n\Exception');
        $lang = array(
            'src'    => 'en',
            'output' => 'de',
            'name'   => 'German',
            'native' => 'Deutsch'
        );

        $locales = array(
            array(
                'region' => 'DE',
                'name'   => 'Germany',
                'native' => 'Deutschland'
            ),
            array(
                'region' => 'CH',
                'name'   => 'Switzerland',
                'native' => 'Schweiz',
                'text' => array(
                    array(
                        'source' => 'This field is required. (CH)',
                        'output' => 'Dieses Feld ist erforderlich. (CH)'
                    ),
                    array(
                        'source' => 'Thursday (CH)',
                        'output' => 'Donnerstag (CH)'
                    ),
                    array(
                        'source' => 'The value length must be between or equal to %1 and %2. (CH)',
                        'output' => 'Der Wert muss zwischen oder gleich %1 und %2 sein. (CH)'
                    )
                )
            )
        );

        I18n::createXmlFile($lang, $locales, __DIR__ . '/../tmp/new_de.xml');
    }

    public function testCreateXmlFileTextNotArrayException()
    {
        $this->setExpectedException('Pop\I18n\Exception');
        $lang = array(
            'src'    => 'en',
            'output' => 'de',
            'name'   => 'German',
            'native' => 'Deutsch'
        );

        $locales = array(
            array(
                'region' => 'DE',
                'name'   => 'Germany',
                'native' => 'Deutschland',
                'text' => '123'
            )
        );

        I18n::createXmlFile($lang, $locales, __DIR__ . '/../tmp/new_de.xml');
    }

    public function testCreateXmlFileNoSourceException()
    {
        $this->setExpectedException('Pop\I18n\Exception');
        $lang = array(
            'src'    => 'en',
            'output' => 'de',
            'name'   => 'German',
            'native' => 'Deutsch'
        );

        $locales = array(
            array(
                'region' => 'DE',
                'name'   => 'Germany',
                'native' => 'Deutschland',
                'text' => array(
                    array()
                )
            )
        );

        I18n::createXmlFile($lang, $locales, __DIR__ . '/../tmp/new_de.xml');
    }

    public function testCreateXmlFromText()
    {
        I18n::createXmlFromText(__DIR__ . '/../tmp/en.txt', __DIR__ . '/../tmp/de.txt', __DIR__ . '/../tmp');
        $this->assertFileExists(__DIR__ . '/../tmp/de.xml');
        unlink(__DIR__ . '/../tmp/de.xml');
    }

    public function testCreateXmlFromTextNoSourceException()
    {
        $this->setExpectedException('Pop\I18n\Exception');
        I18n::createXmlFromText(__DIR__ . '/../tmp/bad.txt', __DIR__ . '/../tmp/de.txt', __DIR__ . '/../tmp');
    }

    public function testCreateXmlFromTextNoOutputException()
    {
        $this->setExpectedException('Pop\I18n\Exception');
        I18n::createXmlFromText(__DIR__ . '/../tmp/en.txt', __DIR__ . '/../tmp/bad.txt', __DIR__ . '/../tmp');
    }

    public function testCreateXmlFromTextNoTargetException()
    {
        $this->setExpectedException('Pop\I18n\Exception');
        I18n::createXmlFromText(__DIR__ . '/../tmp/bad.txt', __DIR__ . '/../tmp/de.txt', __DIR__ . '/../bad');
    }

}

