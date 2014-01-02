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
namespace PopTest\Compress;

use Pop\Loader\Autoloader;
use Pop\Compress\Gzip;

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

