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

class ZipTest extends \PHPUnit_Framework_TestCase
{
/*
    public function testZip()
    {
        if (class_exists('ZipArchive', false)) {
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

            $dir = new Dir(__DIR__ . '/../tmp/test');
            $this->assertGreaterThan(0, count($dir->files));
            $dir->emptyDir();

            rmdir(__DIR__ . '/../tmp/test');

            if (file_exists(__DIR__ . '/../tmp/test.zip')) {
                unlink(__DIR__ . '/../tmp/test.zip');
            }
        }
    }
*/
}

?>