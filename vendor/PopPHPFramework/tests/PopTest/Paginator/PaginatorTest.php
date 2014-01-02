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
namespace PopTest\Paginator;

use Pop\Loader\Autoloader;
use Pop\Paginator\Paginator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class PaginatorTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Paginator\Paginator', new Paginator(array()));
        $this->assertInstanceOf('Pop\Paginator\Paginator', Paginator::factory(array()));
    }

    public function testSetAndGetItems()
    {
        $p = new Paginator(array());
        $p->setBookend(Paginator::DOUBLE_ARROWS);
        $p->setItems(array(1, 2, 3));
        $this->assertEquals(3, count($p->getItems()));
        $this->assertEquals(3, $p->getItemCount());
    }

    public function testSetAndGetPerPage()
    {
        $p = new Paginator(array());
        $p->setPerPage(25);
        $this->assertEquals(25, $p->getPerPage());
    }

    public function testSetAndGetRange()
    {
        $p = new Paginator(array());
        $p->setRange(25);
        $this->assertEquals(25, $p->getRange());
    }

    public function testSetAndGetTotal()
    {
        $p = new Paginator(array());
        $p->setTotal(100);
        $this->assertEquals(100, $p->getTotal());
    }

    public function testSetAndGetSeparator()
    {
        $p = new Paginator(array());
        $p->setSeparator(' : ');
        $this->assertEquals(' : ', $p->getSeparator());
    }

    public function testSetAndGetDateFormat()
    {
        $p = new Paginator(array());
        $p->setDateFormat('m/d/Y');
        $this->assertEquals('m/d/Y', $p->getDateFormat());
    }

    public function testSetAndGetClass()
    {
        $p = new Paginator(array());
        $p->setClassOn('class-on');
        $p->setClassOff('class-off');
        $this->assertEquals('class-on', $p->getClassOn());
        $this->assertEquals('class-off', $p->getClassOff());
    }

    public function testSetAndGetHeader()
    {
        $p = new Paginator(array());
        $p->setHeader('header');
        $this->assertEquals('header', $p->getHeader());
    }

    public function testSetAndGetRowTemplate()
    {
        $p = new Paginator(array());
        $p->setRowTemplate('template');
        $this->assertEquals('template', $p->getRowTemplate());
    }

    public function testSetAndGetFooter()
    {
        $p = new Paginator(array());
        $p->setFooter('footer');
        $this->assertEquals('footer', $p->getFooter());
    }

    public function testRender()
    {
        $rows = array(
            array('name' => 'Test1', 'email' => 'test1@email.com'),
            array('name' => 'Test2', 'email' => 'test2@email.com'),
            array('name' => 'Test3', 'email' => 'test3@email.com'),
            array('name' => 'Test4', 'email' => 'test4@email.com'),
            array('name' => 'Test5', 'email' => 'test5@email.com'),
            array('name' => 'Test6', 'email' => 'test6@email.com'),
            array('name' => 'Test7', 'email' => 'test7@email.com'),
            array('name' => 'Test8', 'email' => 'test8@email.com'),
            array('name' => 'Test9', 'email' => 'test9@email.com'),
            array('name' => 'Test10', 'email' => 'test10@email.com'),
            array('name' => 'Test11', 'email' => 'test11@email.com'),
            array('name' => 'Test12', 'email' => 'test12@email.com'),
            array('name' => 'Test13', 'email' => 'test13@email.com'),
            array('name' => 'Test14', 'email' => 'test14@email.com'),
            array('name' => 'Test15', 'email' => 'test15@email.com'),
            array('name' => 'Test16', 'email' => 'test16@email.com')
        );

        $p = new Paginator($rows, 3, 3);
        $render = $p->render(1, true);

        ob_start();
        $p->render(1);
        $output = ob_get_clean();

        $this->assertContains('<tr><td>Test1</td><td>test1@email.com</td></tr>', $render);
        $this->assertContains('<tr><td>Test1</td><td>test1@email.com</td></tr>', $output);
        $this->assertContains('<tr><td>Test1</td><td>test1@email.com</td></tr>', (string)$p);
    }

    public function testRenderWithTemplate()
    {
        $rows = array(
            array('id' => 1, 'name' => 'Test1', 'email' => 'test1@email.com'),
            array('id' => 2, 'name' => 'Test2', 'email' => 'test2@email.com'),
            array('id' => 3, 'name' => 'Test3', 'email' => 'test3@email.com'),
            array('id' => 4, 'name' => 'Test4', 'email' => 'test4@email.com'),
            array('id' => 5, 'name' => 'Test5', 'email' => 'test5@email.com'),
            array('id' => 6, 'name' => 'Test6', 'email' => 'test6@email.com'),
            array('id' => 7, 'name' => 'Test7', 'email' => 'test7@email.com'),
            array('id' => 8, 'name' => 'Test8', 'email' => 'test8@email.com'),
            array('id' => 9, 'name' => 'Test9', 'email' => 'test9@email.com'),
            array('id' => 10, 'name' => 'Test10', 'email' => 'test10@email.com'),
            array('id' => 11, 'name' => 'Test11', 'email' => 'test11@email.com'),
            array('id' => 12, 'name' => 'Test12', 'email' => 'test12@email.com'),
            array('id' => 13, 'name' => 'Test13', 'email' => 'test13@email.com'),
            array('id' => 14, 'name' => 'Test14', 'email' => 'test14@email.com'),
            array('id' => 15, 'name' => 'Test15', 'email' => 'test15@email.com'),
            array('id' => 16, 'name' => 'Test16', 'email' => 'test16@email.com')
        );

        $header = <<<HEADER
<table class="paged-table" cellpadding="0" cellspacing="0">
    <tr><td colspan="2">[{page_links}]</td></tr>
    <tr><td><strong>Name</strong></td><td><strong>Email</strong></td></tr>

HEADER;

        $rowTemplate = <<<TMPL
    <tr><td><a href="./edit-user.php?id=[{id}]">[{name}]</a></td><td>[{email}]</td></tr>

TMPL;

        $footer = <<<FOOTER
    <tr><td colspan="2">[{page_links}]</td></tr>
</table>

FOOTER;

        $p = new Paginator($rows, 3, 3);
        $p->setHeader($header)
          ->setRowTemplate($rowTemplate)
          ->setFooter($footer);

        $render = $p->render(1, true);

        ob_start();
        $p->render(1);
        $output = ob_get_clean();

        $this->assertContains('<tr><td><a href="./edit-user.php?id=1">Test1</a></td><td>test1@email.com</td></tr>', $render);
        $this->assertContains('<tr><td><a href="./edit-user.php?id=1">Test1</a></td><td>test1@email.com</td></tr>', $output);
        $this->assertContains('<tr><td><a href="./edit-user.php?id=1">Test1</a></td><td>test1@email.com</td></tr>', (string)$p);
    }

}

