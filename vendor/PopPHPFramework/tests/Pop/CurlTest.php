<?php
/**
 * Pop PHP Framework
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
 * @category   Pop
 * @package    Pop_Curl
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

require_once __DIR__ . '/../../library/Pop/Autoloader.php';
Pop_Autoloader::bootstrap();

class Pop_CurlTest extends PHPUnit_Framework_TestCase
{

    public function testCurlConstructor()
    {
        $c = new Pop_Curl(array(CURLOPT_URL => 'http://www.popphp.org/LICENSE.TXT'));
        $class = 'Pop_Curl';
        $this->assertTrue($c instanceof $class);
    }

    public function testCurlSetAndGetOption()
    {
        $c = new Pop_Curl(array(CURLOPT_URL => 'http://www.popphp.org/LICENSE.TXT'));
        $c->setOption(CURLOPT_HEADER, FALSE);
        $this->assertEquals(FALSE, $c->getOption(CURLOPT_HEADER));
    }

    public function testCurlExecute()
    {
        $opts = array(CURLOPT_URL => 'http://www.popphp.org/LICENSE.TXT',
                      CURLOPT_HEADER => FALSE,
                      CURLOPT_RETURNTRANSFER => TRUE);

        $c = new Pop_Curl($opts);
        $output = $c->execute();
        $this->assertEquals(1654, strlen($output));
    }

}

?>