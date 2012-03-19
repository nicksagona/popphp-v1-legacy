Pop PHP Framework
=================

Documentation : Image
---------------------

Изображение компонента обеспечивает стандартизированный обертка API для создания и обработки изображений, который использует GD PHP и Imagick расширения, а также SVG формат изображения. В рамках этого компонента является многофункциональным API для выполнения различных изображений на основе функций. И, поскольку API является стандартным, если проект переходит в другой среде, она должна ухудшать легко.

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
