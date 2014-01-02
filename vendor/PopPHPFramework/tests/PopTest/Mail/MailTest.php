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
namespace PopTest\Mail;

use Pop\Loader\Autoloader;
use Pop\File\Dir;
use Pop\Mail\Mail;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class MailTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Mail\Mail', new Mail());
    }

    public function testConstructorRcpts()
    {
        $rcpts = array(
            array(
                'name'  => 'Test Smith',
                'email' => 'test@email.com'
            ),
            array(
                'name'  => 'Someone Else',
                'email' => 'someone@email.com'
            )
        );
        $m = new Mail('Subject', array('name' => 'Bob Smith', 'email' => 'bob@smith.com'));
        $m->addRecipients($rcpts);
        $this->assertInstanceOf('Pop\Mail\Mail', $m);
    }

    public function testTo()
    {
        $m = new Mail('Subject');
        $m->to('bob@smith.com', 'Bob Smith');
        $m->add('bubba@smith.com', 'Bubba Smith');
        $m->sendAsGroup(true);
        $this->assertEquals(2, count($m->getQueue()));
    }

    public function testFrom()
    {
        $m = new Mail('Subject');
        $m->from('bob@smith.com', 'Bob Smith');
        $this->assertEquals('Bob Smith <bob@smith.com>', $m->getHeader('From'));
        $this->assertEquals('Bob Smith <bob@smith.com>', $m->getHeader('Reply-To'));
    }

    public function testReply()
    {
        $m = new Mail('Subject');
        $m->replyTo('bob@smith.com', 'Bob Smith');
        $this->assertEquals('Bob Smith <bob@smith.com>', $m->getHeader('Reply-To'));
        $this->assertEquals('Bob Smith <bob@smith.com>', $m->getHeader('From'));
    }

    public function testCc()
    {
        $m = new Mail('Subject');
        $m->cc('bob@smith.com', 'Bob Smith');
        $this->assertEquals('Bob Smith <bob@smith.com>', $m->getHeader('Cc'));
        $m->cc(array('test@email.com', 'someone@email.com'));
        $this->assertEquals('test@email.com, someone@email.com', $m->getHeader('Cc'));
    }

    public function testBcc()
    {
        $m = new Mail('Subject');
        $m->bcc('bob@smith.com', 'Bob Smith');
        $this->assertEquals('Bob Smith <bob@smith.com>',$m->getHeader('Bcc'));
        $m->bcc(array('test@email.com', 'someone@email.com'));
        $this->assertEquals('test@email.com, someone@email.com', $m->getHeader('Bcc'));
    }

    public function testConstructorRcptException()
    {
        $this->setExpectedException('Pop\Mail\Exception');
        $m = new Mail('Subject', array('name' => 'Bob Smith'));
    }

    public function testRcptException()
    {
        $this->setExpectedException('Pop\Mail\Exception');
        $m = new Mail();
        $m->addRecipients('Subject', array(array('name' => 'Bob Smith'), array('name' => 'Bob Smith')));
    }

    public function testSetAndGetSubject()
    {
        $m = new Mail();
        $m->setSubject('Hello World');
        $this->assertEquals('Hello World', $m->getSubject());
    }

    public function testSetAndGetBoundary()
    {
        $m = new Mail();
        $m->setBoundary('some-boundary');
        $this->assertEquals('some-boundary', $m->getBoundary());
    }

    public function testSetAndGetEol()
    {
        $m = new Mail();
        $m->setEol(Mail::LF);
        $this->assertEquals("\n", $m->getEol());
    }

    public function testSetAndGetCharset()
    {
        $m = new Mail();
        $m->setCharset('utf-8');
        $this->assertEquals('utf-8', $m->getCharset());
    }

    public function testSetAndGetText()
    {
        $m = new Mail();
        $m->setText('Hello World');
        $this->assertEquals('Hello World', $m->getText());
    }

    public function testSetAndGetHtml()
    {
        $m = new Mail();
        $m->setHtml('Hello World');
        $this->assertEquals('Hello World', $m->getHtml());
    }

    public function testSetAndGetHeaders()
    {
        $m = new Mail();
        $m->setHeader('X-Reply-To', 'noreply@test.com');
        $m->setHeader('X-Reply-To', 'Bob <noreply@test.com>');
        $m->replyTo('noreply@test.com');
        $m->setHeaders(array('Reply' => 'noreply@test.com'));
        $m->setParams(' -i');
        $m->setParams(array(' -t'));
        $m->setParams();
        $this->assertEquals('noreply@test.com', $m->getHeader('Reply-To'));
        $this->assertEquals(4, count($m->getHeaders()));
    }

    public function testAttachFile()
    {
        $m = new Mail();
        $m->attachFile(__DIR__ . '/../tmp/test.jpg');
        $this->assertInstanceOf('Pop\Mail\Mail', new Mail());
    }

    public function testAttachFileException()
    {
        $this->setExpectedException('Pop\Mail\Exception');
        $m = new Mail();
        $m->attachFile(__DIR__ . '/../tmp/test.txt');
    }

    public function testInitText()
    {
        $m = new Mail('Subject', array('name' => 'Bob Smith', 'email' => 'bob@smith.com'));
        $m->setText('Hello');
        $m->getMessage()->init();
    }

    public function testInitHtml()
    {
        $m = new Mail('Subject', array('name' => 'Bob Smith', 'email' => 'bob@smith.com'));
        $m->setHtml('Hello');
        $m->getMessage()->init();
    }

    public function testInitHtmlAndText()
    {
        $m = new Mail('Subject', array('name' => 'Bob Smith', 'email' => 'bob@smith.com'));
        $m->setHtml('Hello');
        $m->setText('Hello');
        $m->getMessage()->init();
    }

    public function testInitHtmlTextAndFile()
    {
        $m = new Mail('Subject', array('name' => 'Bob Smith', 'email' => 'bob@smith.com'));
        $m->attachFile(__DIR__ . '/../tmp/test.jpg');
        $m->setHtml('Hello');
        $m->setText('Hello');
        $m->getMessage()->init();
    }

    public function testInitException()
    {
        $this->setExpectedException('Pop\Mail\Exception');
        $m = new Mail('Subject', array('name' => 'Bob Smith', 'email' => 'bob@smith.com'));
        $m->getMessage()->init();
    }

    public function testSaveTo()
    {
        $m = new Mail('Subject', array('name' => 'Bob Smith', 'email' => 'bob@smith.com'), 'Hello World');
        $m->setHtml('Hello');
        $m->setText('Hello');
        $m->saveTo(__DIR__ . '/../tmp');

        $d = new Dir(__DIR__ . '/../tmp');
        $files = $d->getFiles();
        $exists = false;
        foreach ($files as $file) {
            if (strpos($file, 'popphpmail') !== false) {
                $exists = true;
                unlink(__DIR__ . '/../tmp/' . $file);
            }
        }
        $this->assertTrue($exists);
    }

}

