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
 * @package    Pop_Ftp
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

require_once __DIR__ . '/../../library/Pop/Autoloader.php';
Pop_Autoloader::bootstrap();

class Pop_FtpTest extends PHPUnit_Framework_TestCase
{

    public function testFtpConstructor()
    {
        $f = new Pop_Ftp('ftp.yourserver.com', 'user', 'pass');
        $class = 'Pop_Ftp';
        $this->assertTrue($f instanceof $class);
    }

    public function testFtpChDir()
    {
        $f = new Pop_Ftp('ftp.yourserver.com', 'user', 'pass');
        $f->chdir('./httpdocs/');
        $this->assertEquals($f->pwd(), '/httpdocs');
    }

}

?>