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
 * @package    Pop_Language
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

require_once dirname(__FILE__) . '/../../library/Pop/Autoloader.php';
Pop_Autoloader::bootstrap();

class Pop_LocaleTest extends PHPUnit_Framework_TestCase
{

    public function testLocaleConstructor()
    {
        $l = new Pop_Locale('fr');
        $class = 'Pop_Locale';
        $this->assertTrue($l instanceof $class);
    }

    public function testLanguageGet()
    {
        $l = new Pop_Locale('fr');
        $this->assertTrue($l->getLanguage() == 'fr');
    }

    public function testLanguageReturn()
    {
        $l = new Pop_Locale('fr');
        $this->assertTrue($l->__('Error:') == 'Erreur:');
    }

    public function testLanguageGetLangs()
    {
        $l = new Pop_Locale('fr');
        $this->assertTrue(count($l->getLanguages()) == 12);
    }

}

?>