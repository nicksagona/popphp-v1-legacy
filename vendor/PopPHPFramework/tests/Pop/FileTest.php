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
 * @package    Pop_File
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

require_once __DIR__ . '/../../library/Pop/Autoloader.php';
Pop_Autoloader::bootstrap();

class Pop_FileTest extends PHPUnit_Framework_TestCase
{

    public function testFileConstructor()
    {
        $f = new Pop_File('new_file.txt');
        $class = 'Pop_File';
        $this->assertTrue($f instanceof $class);
    }

    public function testFileRead()
    {
        $f = new Pop_File('../../public/examples/assets/files/test.txt');
        $this->assertEquals('Test Text File.', $f->read());
    }

    public function testFileWrite()
    {
        $f = new Pop_File('../../public/examples/assets/files/new_test.txt');
        $data = 'This is a write test.';

        $f->write($data);
        $this->assertEquals($data, $f->read());

        $f->delete();
    }

    public function testFileCopy()
    {
        $f = new Pop_File('../../public/examples/assets/files/test.txt');
        $f->copy('../../public/examples/assets/files/copy_test.txt');

        $this->assertTrue(file_exists('../../public/examples/assets/files/copy_test.txt'));

        unlink('../../public/examples/assets/files/copy_test.txt');
    }

    public function testFileMove()
    {
        $f = new Pop_File('../../public/examples/assets/files/test.txt');
        $f->move('../../public/examples/assets/files/move_test.txt');

        $this->assertFalse(file_exists('../../public/examples/assets/files/test.txt'));
        $this->assertTrue(file_exists('../../public/examples/assets/files/move_test.txt'));

        $f = new Pop_File('../../public/examples/assets/files/move_test.txt');
        $f->move('../../public/examples/assets/files/test.txt');
    }

    public function testFileDelete()
    {
        $f = new Pop_File('../../public/examples/assets/files/test.txt');
        $f->copy('../../public/examples/assets/files/delete_test.txt');

        $f = new Pop_File('../../public/examples/assets/files/delete_test.txt');
        $f->delete();

        $this->assertFalse(file_exists('../../public/examples/assets/files/delete_test.txt'));
    }

}

?>