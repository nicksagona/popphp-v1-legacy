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
use Pop\Archive\Archive;
use Pop\Compress\Bzip2;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class Bzip2Test extends \PHPUnit_Framework_TestCase
{

    public $string = 'Hello World!';

    public function testBzip2WithString()
    {
        if (function_exists('bzopen')) {
            $compressed = Bzip2::compress($this->string);
            $decompressed = Bzip2::decompress($compressed);
            $this->assertEquals($this->string, $decompressed);
        }
    }

    public function testBzip2WithFile()
    {
        if (function_exists('bzopen')) {
            $compressed = Bzip2::compress(__DIR__ . '/../tmp/access.txt');
            $this->fileExists(__DIR__ . '/../tmp/access.txt.bz2');
            $decompressed = Bzip2::decompress($compressed);
            $this->fileExists(__DIR__ . '/../tmp/access.txt');
            if (file_exists(__DIR__ . '/../tmp/access.txt.bz2')) {
                unlink(__DIR__ . '/../tmp/access.txt.bz2');
            }
        }
    }

    public function testBzip2WithTarFile()
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

            $compressed = Bzip2::compress(__DIR__ . '/../tmp/test.tar');
            copy($compressed, __DIR__ . '/../tmp/test.tbz2');
            copy($compressed, __DIR__ . '/../tmp/test.tbz');

            $this->fileExists(__DIR__ . '/../tmp/test.tar');
            $this->fileExists(__DIR__ . '/../tmp/test.tar.bz2');
            $this->fileExists(__DIR__ . '/../tmp/test.tbz2');
            $this->fileExists(__DIR__ . '/../tmp/test.tbz');

            if (file_exists(__DIR__ . '/../tmp/test.tar')) {
                unlink(__DIR__ . '/../tmp/test.tar');
            }

            // Test *.tar.bz2
            $decompressed = Bzip2::decompress(__DIR__ . '/../tmp/test.tar.bz2');
            $this->fileExists(__DIR__ . '/../tmp/test.tar');
            if (file_exists(__DIR__ . '/../tmp/test.tar')) {
                unlink(__DIR__ . '/../tmp/test.tar');
            }
            if (file_exists(__DIR__ . '/../tmp/test.tar.bz2')) {
                unlink(__DIR__ . '/../tmp/test.tar.bz2');
            }

            // Test *.tbz2
            $decompressed = Bzip2::decompress(__DIR__ . '/../tmp/test.tbz2');
            $this->fileExists(__DIR__ . '/../tmp/test.tar');
            if (file_exists(__DIR__ . '/../tmp/test.tar')) {
                unlink(__DIR__ . '/../tmp/test.tar');
            }
            if (file_exists(__DIR__ . '/../tmp/test.tbz2')) {
                unlink(__DIR__ . '/../tmp/test.tbz2');
            }

            // Test *.tbz
            $decompressed = Bzip2::decompress(__DIR__ . '/../tmp/test.tbz');
            $this->fileExists(__DIR__ . '/../tmp/test.tar');
            if (file_exists(__DIR__ . '/../tmp/test.tar')) {
                unlink(__DIR__ . '/../tmp/test.tar');
            }
            if (file_exists(__DIR__ . '/../tmp/test.tbz')) {
                unlink(__DIR__ . '/../tmp/test.tbz');
            }
        }
    }

}

