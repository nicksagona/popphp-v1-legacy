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
 * @package    Pop_Autoloader
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

// Require the library's autoloader.
require_once dirname(__FILE__) . '/../../library/Pop/Autoloader.php';

// Set the include path of the application.
set_include_path(dirname(__FILE__) . '/../../application/' . PATH_SEPARATOR . get_include_path());

// Call the autoloader's bootstrap function.
Pop_Autoloader::bootstrap();

class Pop_AutoloaderTest extends PHPUnit_Framework_TestCase
{

    public function testAutoloaderLibrary()
    {

        $s = new Pop_String('string');
        $class = 'Pop_String';
        $this->assertTrue($s instanceof $class);

    }

}

?>