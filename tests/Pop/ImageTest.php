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
 * @package    Pop_Image
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

require_once dirname(__FILE__) . '/../../library/Pop/Autoloader.php';
Pop_Autoloader::bootstrap();

class Pop_ImageTest extends PHPUnit_Framework_TestCase
{

    public function testImageConstructor()
    {
        $i = new Pop_Image('../../public/examples/assets/images/test.jpg');
        $class = 'Pop_Image';
        $this->assertTrue($i instanceof $class);
    }

    public function testImageResize()
    {
        $i = new Pop_Image('../../public/examples/assets/images/test.jpg');
        $i->copy('../../public/examples/assets/images/test2.jpg');

        $i = new Pop_Image('../../public/examples/assets/images/test2.jpg');
        $i->resize(120);

        $size = getimagesize('../../public/examples/assets/images/test2.jpg');

        $this->assertEquals(120, $i->width);
        $this->assertEquals(120, $size[0]);

        $i->delete();
    }

    public function testImageScale()
    {
        $i = new Pop_Image('../../public/examples/assets/images/test.jpg');
        $i->copy('../../public/examples/assets/images/test2.jpg');

        $i = new Pop_Image('../../public/examples/assets/images/test2.jpg');
        $i->scale(0.5);

        $size = getimagesize('../../public/examples/assets/images/test2.jpg');

        $this->assertEquals(320, $i->width);
        $this->assertEquals(320, $size[0]);

        $i->delete();
    }

    public function testImageCrop()
    {
        $i = new Pop_Image('../../public/examples/assets/images/test.jpg');
        $i->copy('../../public/examples/assets/images/test2.jpg');

        $i = new Pop_Image('../../public/examples/assets/images/test2.jpg');
        $i->cropThumb(50);

        $size = getimagesize('../../public/examples/assets/images/test2.jpg');

        $this->assertEquals(50, $i->width);
        $this->assertEquals(50, $size[0]);

        $i->delete();
    }

    public function testImageConvert()
    {
        $i = new Pop_Image('../../public/examples/assets/images/test.jpg');
        $i->copy('../../public/examples/assets/images/test2.jpg');

        $i = new Pop_Image('../../public/examples/assets/images/test2.jpg');
        $i->convert('png');

        $this->assertTrue(file_exists('../../public/examples/assets/images/test2.png'));

        $i->delete();
        unlink('../../public/examples/assets/images/test2.jpg');
    }

    public function testImageColorTotal()
    {
        $i = new Pop_Image('../../public/examples/assets/images/test.gif');
        $this->assertEquals(16, $i->colorTotal());
    }

    public function testImageGetColors()
    {
        $i = new Pop_Image('../../public/examples/assets/images/test.gif');
        $this->assertEquals(16, count($i->getColors()));
    }

}

?>