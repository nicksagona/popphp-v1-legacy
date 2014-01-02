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
namespace PopTest\Archive;

use Pop\Loader\Autoloader;
use Pop\Archive\Archive;
use Pop\File\Dir;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class TarTest extends \PHPUnit_Framework_TestCase
{

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
            $a->addFiles(__DIR__ . '/ZipTest.php');
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
            chmod(__DIR__ . '/../tmp/test.tar.gz', 0777);

            unset($a);

            $a = new Archive(__DIR__ . '/../tmp/test.tar.gz');

            mkdir(__DIR__ . '/../tmp/test');
            chmod(__DIR__ . '/../tmp/test', 0777);

            $files = $a->listFiles();
            $files = $a->listFiles(true);

            $this->assertTrue(is_array($files));

            $a->extract(__DIR__ . '/../tmp/test');

            $dir = new Dir(__DIR__ . '/../tmp/test');
            $this->assertGreaterThan(0, count($dir->getFiles()));
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
            chmod(__DIR__ . '/../tmp/test.tar.bz2', 0777);

            unset($a);

            $a = new Archive(__DIR__ . '/../tmp/test.tar.bz2');

            mkdir(__DIR__ . '/../tmp/test');
            chmod(__DIR__ . '/../tmp/test', 0777);

            $a->extract(__DIR__ . '/../tmp/test');

            $dir = new Dir(__DIR__ . '/../tmp/test');
            $this->assertGreaterThan(0, count($dir->getFiles()));
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

    public function testNoCompress()
    {
        $tar = false;
        $includePath = explode(PATH_SEPARATOR, get_include_path());

        foreach ($includePath as $path) {
            if (file_exists($path . DIRECTORY_SEPARATOR . 'Archive' . DIRECTORY_SEPARATOR . 'Tar.php')) {
                $tar = true;
            }
        }

        if ($tar) {
            $a = new Archive(__DIR__ . '/../tmp/test.tar');
            $a->addFiles(__DIR__ . '/../tmp');
            $a->compress('.noext');
            $this->fileExists(__DIR__ . '/../tmp/test.tar');
            if (file_exists(__DIR__ . '/../tmp/test.tar')) {
                unlink(__DIR__ . '/../tmp/test.tar');
            }
        }

    }

}

