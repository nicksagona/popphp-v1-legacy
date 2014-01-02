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
use Pop\Compress\Zlib;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ZlibTest extends \PHPUnit_Framework_TestCase
{

    public $string = 'Hello World!';

    public function testZlibWithString()
    {
        if (function_exists('gzcompress')) {
            $compressed = Zlib::compress($this->string);
            $decompressed = Zlib::decompress($compressed);
            $this->assertEquals($this->string, $decompressed);
        }
    }

}

