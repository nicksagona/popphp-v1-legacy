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

namespace PopTest\Mail;

use Pop\Loader\Autoloader,
    Pop\File\File,
    Pop\Mail\Mail;

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
        $m = new Mail(array('name' => 'Bob Smith', 'email' => 'bob@smith.com'));
        $m->addRecipients($rcpts);
        $this->assertInstanceOf('Pop\Mail\Mail', new Mail());
    }

    public function testConstructorRcptException()
    {
        $this->setExpectedException('Pop\Mail\Exception');
        $m = new Mail(array('name' => 'Bob Smith'));
    }

    public function testRcptException()
    {
        $this->setExpectedException('Pop\Mail\Exception');
        $m = new Mail();
        $m->addRecipients(array(array('name' => 'Bob Smith'), array('name' => 'Bob Smith')));
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
        $m->setHeader('X-Reply-To', array('email' => 'noreply@test.com'));
        $m->setHeader('X-Reply-To', array('name' => 'Bob', 'email' => 'noreply@test.com'));
        $m->setHeader('X-Reply-To', array('Bob', 'noreply@test.com'));
        $m->setHeader('Reply-To', 'noreply@test.com');
        $m->setHeaders(array('Reply' => 'noreply@test.com'));
        $m->setParams(' -i');
        $m->setParams(array(' -t'));
        $m->setParams();
        $this->assertEquals('noreply@test.com', $m->getHeader('Reply-To'));
        $this->assertEquals(3, count($m->getHeaders()));
    }

    public function testAttachFile()
    {
        $m = new Mail();
        $m->attachFile(__DIR__ . '/../tmp/test.jpg');
        $m->attachFile(new File(__DIR__ . '/../tmp/test.gif'));
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
        $m = new Mail(array('name' => 'Bob Smith', 'email' => 'bob@smith.com'));
        $m->setText('Hello');
        $m->init();
    }

    public function testInitHtml()
    {
        $m = new Mail(array('name' => 'Bob Smith', 'email' => 'bob@smith.com'));
        $m->setHtml('Hello');
        $m->init();
    }

    public function testInitHtmlAndText()
    {
        $m = new Mail(array('name' => 'Bob Smith', 'email' => 'bob@smith.com'));
        $m->setHtml('Hello');
        $m->setText('Hello');
        $m->init();
    }

    public function testInitHtmlTextAndFile()
    {
        $m = new Mail(array('name' => 'Bob Smith', 'email' => 'bob@smith.com'));
        $m->attachFile(__DIR__ . '/../tmp/test.jpg');
        $m->setHtml('Hello');
        $m->setText('Hello');
        $m->init();
    }

    public function testInitException()
    {
        $this->setExpectedException('PHPUnit_Framework_Error_Notice');
        $m = new Mail(array('name' => 'Bob Smith', 'email' => 'bob@smith.com'));
        $m->init();
    }

}

