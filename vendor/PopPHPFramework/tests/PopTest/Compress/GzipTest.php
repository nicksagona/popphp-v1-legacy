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

namespace PopTest\Compress;

use Pop\Loader\Autoloader,
    Pop\Compress\Gzip;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class GzipTest extends \PHPUnit_Framework_TestCase
{

    public $string = 'Hello World!';

    public function testGzipWithString()
    {
        if (function_exists('gzencode')) {
            $compressed = Gzip::compress($this->string);
            $decompressed = Gzip::decompress($compressed);
            $this->assertEquals($this->string, $decompressed);
        }
    }

    public function testGzipWithFile()
    {
        if (function_exists('gzcompress')) {
            $compressed = Gzip::compress(__DIR__ . '/../tmp/access.txt');
            $this->fileExists(__DIR__ . '/../tmp/access.txt.gz');
            $decompressed = Gzip::decompress($compressed);
            $this->fileExists(__DIR__ . '/../tmp/access.txt');
            if (file_exists(__DIR__ . '/../tmp/access.txt.gz')) {
                unlink(__DIR__ . '/../tmp/access.txt.gz');
            }
        }
    }

}

