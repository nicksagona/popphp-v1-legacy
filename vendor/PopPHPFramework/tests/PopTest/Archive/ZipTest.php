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

class ZipTest extends \PHPUnit_Framework_TestCase
{

    public function testZip()
    {
        if (class_exists('ZipArchive', false)) {
            $a = new Archive('test.zip');
            unset($a);

            $a = new Archive('C:\Projects\..\test.zip');
            unset($a);

            $a = new Archive(__DIR__ . '/../tmp/test.zip');
            $a->addFiles(array(
                __DIR__ . '/../tmp/access.txt',
                __DIR__ . '/../tmp/test.jpg',
                __DIR__ . '/TarTest.php',
                __DIR__ . '/../../../../../public/examples/assets'
            ));

            $this->assertGreaterThan(1, count($a->adapter()->getDirs()));

            unset($a);

            $a = new Archive(__DIR__ . '/../tmp/test.zip');
            $a->addFiles(__DIR__ . '/./');
            unset($a);

            $a = new Archive(__DIR__ . '/../tmp/test.zip');
            $a->addFiles(__DIR__ . '/../tmp');
            $this->assertFileExists(__DIR__ . '/../tmp/test.zip');
            $this->assertGreaterThan(60000, $a->getSize());

            chmod(__DIR__ . '/../tmp/test.zip', 0777);

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
            unset($a);
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

    public function testZipExtract()
    {
        if (class_exists('ZipArchive', false)) {
            $a = new Archive(__DIR__ . '/../tmp/test.zip');
            $a->addFiles(__DIR__ . '/../tmp');

            mkdir(__DIR__ . '/../tmp/test');
            chmod(__DIR__ . '/../tmp/test', 0777);
            chmod(__DIR__ . '/../tmp/test.zip', 0777);

            $a->extract(__DIR__ . '/../tmp/test');

            unset($a);

            $dir = new Dir(__DIR__ . '/../tmp/test');
            $this->assertGreaterThan(0, count($dir->getFiles()));
            $dir->emptyDir();

            rmdir(__DIR__ . '/../tmp/test');

            if (file_exists(__DIR__ . '/../tmp/test.zip')) {
                unlink(__DIR__ . '/../tmp/test.zip');
            }
        }
    }

}

