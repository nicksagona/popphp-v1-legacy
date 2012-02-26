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

namespace Pop;

use Pop\Loader\Autoloader,
    Pop\Filter\Crypt;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class CryptTest extends \PHPUnit_Framework_TestCase
{

    public $string = 'Hello World';

    public $key = '123456789';

    public function testCrypt()
    {
        $encrypted = Crypt::encrypt($this->string, $this->key);
        $decrypted = Crypt::decrypt($encrypted, $this->key);
        $this->assertEquals($this->string, $decrypted);
    }

    public function testEncrpytIvTooLong()
    {
        $this->setExpectedException('Pop\\Filter\\Exception');
        $encrypted = Crypt::encrypt($this->string, '2132454847894651432132123156423132');
    }

    public function testDecrpytIvTooLong()
    {
        $this->setExpectedException('Pop\\Filter\\Exception');
        $encrypted = Crypt::encrypt($this->string, $this->key);
        $decrypted = Crypt::decrypt($encrypted, '2132454847894651432132123156423132');
    }

}

