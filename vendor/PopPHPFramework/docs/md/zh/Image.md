Pop PHP Framework
=================

Documentation : Image
---------------------

图像组件提供了用于创建和操纵图像，利用PHP的GD和Imagick扩展，以及SVG图像格式的标准化API的包装。在这个组件是一个功能丰富的API执行许多不同的基于图像的功能。和，因为API是标准化的，如果一个项目移动到不同的环境，它应该降低容易。

<pre>
use Pop\Color\Rgb,
    Pop\Image\Gd;

$image = new Gd('new-image.jpg', 640, 480, new Rgb(255, 0, 0));
$image->setFillColor(new Rgb(0, 0, 255))
      ->setStrokeColor(new Rgb(255, 255, 255))
      ->setStrokeWidth(3)
      ->addEllipse(320, 240, 150, 75)
      ->output();

$image->destroy();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
