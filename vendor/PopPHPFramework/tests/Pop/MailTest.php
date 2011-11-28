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
 * @package    Pop_Mail
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

require_once __DIR__ . '/../../library/Pop/Autoloader.php';
Pop_Autoloader::bootstrap();

class Pop_MailTest extends PHPUnit_Framework_TestCase
{

    public function testMailConstructor()
    {
        $m = new Pop_Mail('test@email.com', 'Test Smith', 'Hello World!');
        $class = 'Pop_Mail';
        $this->assertTrue($m instanceof $class);
    }

    public function testMailSetAndGetSubject()
    {
        $m = new Pop_Mail('test@email.com', 'Test Smith', 'Hello World!');
        $m->setSubject('New Subject');
        $this->assertEquals('New Subject', $m->getSubject());
    }

    public function testMailSetAndGetBoundary()
    {
        $m = new Pop_Mail('test@email.com', 'Test Smith', 'Hello World!');
        $m->setBoundary('border');
        $this->assertEquals('border', $m->getBoundary());
    }

    public function testMailSetAndGetCharset()
    {
        $m = new Pop_Mail('test@email.com', 'Test Smith', 'Hello World!');
        $m->setCharset('iso-8859-1');
        $this->assertEquals('iso-8859-1', $m->getCharset());
    }

}

?>