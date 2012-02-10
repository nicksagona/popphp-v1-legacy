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

namespace PopTest\Archive;

use Pop\Loader\Autoloader,
    Pop\Archive\Archive,
    Pop\Dir\Dir;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ArchiveTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $a = new Archive(__DIR__ . '/../tmp/test.tar');
        $class = 'Pop\\Archive\\Archive';
        $this->assertTrue($a instanceof $class);
    }

    public function testAdapter()
    {
        $tar = false;
        $includePath = explode(PATH_SEPARATOR, get_include_path());

        foreach ($includePath as $path) {
            if (file_exists($path . DIRECTORY_SEPARATOR . 'Archive' . DIRECTORY_SEPARATOR . 'Tar.php')) {
                $tar = true;
            }
        }
        if ($tar) {
            $a = Archive::factory(__DIR__ . '/../tmp/test.tar');
            $a->addFiles(__DIR__ . '/../tmp/access.txt');
            $this->fileExists(__DIR__ . '/../tmp/test.tar');

            unset($a);

            if (file_exists(__DIR__ . '/../tmp/test.tar')) {
                unlink(__DIR__ . '/../tmp/test.tar');
            }

            $a = Archive::factory(__DIR__ . '/../tmp/test.tar');
            $a->addFiles(__DIR__ . '/../tmp');
            $this->fileExists(__DIR__ . '/../tmp/test.tar');

            unset($a);

            $a = Archive::factory(__DIR__ . '/../tmp/test.tar');
            $class = 'Pop\\Archive\\Adapter\\Tar';
            $this->assertTrue($a->adapter() instanceof $class);

            $class = 'Archive_Tar';
            $this->assertTrue($a->archive() instanceof $class);

            $files = $a->listFiles();
            $files = $a->listFiles(true);
            $this->assertTrue(is_array($files));
            if (file_exists(__DIR__ . '/../tmp/test.tar')) {
                unlink(__DIR__ . '/../tmp/test.tar');
            }
        }
    }

    public function testTgz()
    {
        $tar = false;
        $includePath = explode(PATH_SEPARATOR, get_include_path());

        foreach ($includePath as $path) {
            if (file_exists($path . DIRECTORY_SEPARATOR . 'Archive' . DIRECTORY_SEPARATOR . 'Tar.php')) {
                $tar = true;
            }
        }

        if (($tar) && function_exists('gzcompress')) {
            $a = new Archive(__DIR__ . '/../tmp/test.tar');
            $a->addFiles(__DIR__ . '/../tmp');
            $a->compress();
            $this->assertFileExists(__DIR__ . '/../tmp/test.tar.gz');
            $this->assertGreaterThan(60000, $a->getSize());

            if (file_exists(__DIR__ . '/../tmp/test.tar.gz')) {
                unlink(__DIR__ . '/../tmp/test.tar.gz');
            }

            unset($a);

            $a = new Archive(__DIR__ . '/../tmp/test.tar');
            $a->addFiles(__DIR__ . '/../tmp');
            $a->compress('tgz');
            $this->assertFileExists(__DIR__ . '/../tmp/test.tgz');
            $this->assertGreaterThan(60000, $a->getSize());

            if (file_exists(__DIR__ . '/../tmp/test.tgz')) {
                unlink(__DIR__ . '/../tmp/test.tgz');
            }
        }
    }

    public function testTbz2()
    {
        $tar = false;
        $includePath = explode(PATH_SEPARATOR, get_include_path());

        foreach ($includePath as $path) {
            if (file_exists($path . DIRECTORY_SEPARATOR . 'Archive' . DIRECTORY_SEPARATOR . 'Tar.php')) {
                $tar = true;
            }
        }

        if (($tar) && function_exists('bzopen')) {
            $a = new Archive(__DIR__ . '/../tmp/test.tar');
            $a->addFiles(__DIR__ . '/../tmp');
            $a->compress('bz');
            $this->assertFileExists(__DIR__ . '/../tmp/test.tar.bz2');
            $this->assertGreaterThan(60000, $a->getSize());

            if (file_exists(__DIR__ . '/../tmp/test.tar.bz2')) {
                unlink(__DIR__ . '/../tmp/test.tar.bz2');
            }

            unset($a);

            $a = new Archive(__DIR__ . '/../tmp/test.tar');
            $a->addFiles(__DIR__ . '/../tmp');
            $a->compress('tbz2');
            $this->assertFileExists(__DIR__ . '/../tmp/test.tbz2');
            $this->assertGreaterThan(60000, $a->getSize());

            if (file_exists(__DIR__ . '/../tmp/test.tbz2')) {
                unlink(__DIR__ . '/../tmp/test.tbz2');
            }

            unset($a);

            $a = new Archive(__DIR__ . '/../tmp/test.tar');
            $a->addFiles(__DIR__ . '/../tmp');
            $a->compress('tbz');
            $this->assertFileExists(__DIR__ . '/../tmp/test.tbz');
            $this->assertGreaterThan(60000, $a->getSize());

            if (file_exists(__DIR__ . '/../tmp/test.tbz')) {
                unlink(__DIR__ . '/../tmp/test.tbz');
            }
        }
    }

    public function testZip()
    {
        if (class_exists('ZipArchive', false)) {
            $a = new Archive(__DIR__ . '/../tmp/test.zip');
            $a->addFiles(__DIR__ . '/../tmp');
            $this->assertFileExists(__DIR__ . '/../tmp/test.zip');
            $this->assertGreaterThan(60000, $a->getSize());

            unset($a);


            mkdir(__DIR__ . '/../tmp/test');
            mkdir(__DIR__ . '/../tmp/test/test');
            touch(__DIR__ . '/../tmp/empty');
            touch(__DIR__ . '/../tmp/test/empty');
            touch(__DIR__ . '/../tmp/test/test/empty');
            chmod(__DIR__ . '/../tmp/test', 0777);
            chmod(__DIR__ . '/../tmp/test/test', 0777);
            chmod(__DIR__ . '/../tmp/empty', 0777);
            chmod(__DIR__ . '/../tmp/test/empty', 0777);
            chmod(__DIR__ . '/../tmp/test/test/empty', 0777);

            $a = new Archive(__DIR__ . '/../tmp/test.zip');
            $a->addFiles(__DIR__ . '/../tmp/empty');
            $a->addFiles(__DIR__ . '/../tmp/test');

            $files = $a->listFiles();
            $files = $a->listFiles(true);
            $this->assertTrue(is_array($files));

            if (file_exists(__DIR__ . '/../tmp/test.zip')) {
                unlink(__DIR__ . '/../tmp/test.zip');
            }
            if (file_exists(__DIR__ . '/../tmp/empty')) {
                unlink(__DIR__ . '/../tmp/empty');
            }
            $dir = new Dir(__DIR__ . '/../tmp/test');
            $dir->emptyDir();
            rmdir(__DIR__ . '/../tmp/test');
        }
    }

    public function testTgzExtract()
    {
        $tar = false;
        $includePath = explode(PATH_SEPARATOR, get_include_path());

        foreach ($includePath as $path) {
            if (file_exists($path . DIRECTORY_SEPARATOR . 'Archive' . DIRECTORY_SEPARATOR . 'Tar.php')) {
                $tar = true;
            }
        }

        if (($tar) && function_exists('gzcompress')) {
            $a = new Archive(__DIR__ . '/../tmp/test.tar');
            $a->addFiles(__DIR__ . '/../tmp');
            $a->compress();

            unset($a);

            $a = new Archive(__DIR__ . '/../tmp/test.tar.gz');

            mkdir(__DIR__ . '/../tmp/test');
            chmod(__DIR__ . '/../tmp/test', 0777);

            $a->extract(__DIR__ . '/../tmp/test');

            $dir = new Dir(__DIR__ . '/../tmp/test');
            $this->assertGreaterThan(0, count($dir->files));
            $dir->emptyDir();

            rmdir(__DIR__ . '/../tmp/test');

            if (file_exists(__DIR__ . '/../tmp/test.tar')) {
                unlink(__DIR__ . '/../tmp/test.tar');
            }

            if (file_exists(__DIR__ . '/../tmp/test.tar.gz')) {
                unlink(__DIR__ . '/../tmp/test.tar.gz');
            }
        }
    }

    public function testTbz2Extract()
    {
        $tar = false;
        $includePath = explode(PATH_SEPARATOR, get_include_path());

        foreach ($includePath as $path) {
            if (file_exists($path . DIRECTORY_SEPARATOR . 'Archive' . DIRECTORY_SEPARATOR . 'Tar.php')) {
                $tar = true;
            }
        }

        if (($tar) && function_exists('bzopen')) {
            $a = new Archive(__DIR__ . '/../tmp/test.tar');
            $a->addFiles(__DIR__ . '/../tmp');
            $a->compress('bz2');

            unset($a);

            $a = new Archive(__DIR__ . '/../tmp/test.tar.bz2');

            mkdir(__DIR__ . '/../tmp/test');
            chmod(__DIR__ . '/../tmp/test', 0777);

            $a->extract(__DIR__ . '/../tmp/test');

            $dir = new Dir(__DIR__ . '/../tmp/test');
            $this->assertGreaterThan(0, count($dir->files));
            $dir->emptyDir();

            rmdir(__DIR__ . '/../tmp/test');

            if (file_exists(__DIR__ . '/../tmp/test.tar')) {
                unlink(__DIR__ . '/../tmp/test.tar');
            }

            if (file_exists(__DIR__ . '/../tmp/test.tar.bz2')) {
                unlink(__DIR__ . '/../tmp/test.tar.bz2');
            }
        }
    }

    public function testZipExtract()
    {
        if (class_exists('ZipArchive', false)) {
            $a = new Archive(__DIR__ . '/../tmp/test.zip');
            $a->addFiles(__DIR__ . '/../tmp');

            mkdir(__DIR__ . '/../tmp/test');
            chmod(__DIR__ . '/../tmp/test', 0777);

            $a->extract(__DIR__ . '/../tmp/test');

            $dir = new Dir(__DIR__ . '/../tmp/test');
            $this->assertGreaterThan(0, count($dir->files));
            $dir->emptyDir();

            rmdir(__DIR__ . '/../tmp/test');

            if (file_exists(__DIR__ . '/../tmp/test.zip')) {
                unlink(__DIR__ . '/../tmp/test.zip');
            }
        }
    }

}

?>