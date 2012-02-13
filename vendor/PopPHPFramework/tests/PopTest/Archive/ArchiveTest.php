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

}

