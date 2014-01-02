Pop PHP Framework
=================

Documentation : Image
---------------------

Home

Изображение компонент обеспечивает стандартизированный обертку API для
создания и обработки изображений, которая использует GD PHP и Imagick
расширений, а также изображений в формате SVG. В рамках этого компонента
является многофункциональным API для выполнения различных изображений на
основе функций. И, поскольку API является стандартным, если проект
переходит в другую среду, она должна ухудшать легко.

    use Pop\Color\Space\Rgb,
        Pop\Image\Gd;

    $image = new Gd('new-image.jpg', 640, 480, new Rgb(255, 0, 0));
    $image->setFillColor(new Rgb(0, 0, 255))
          ->setStrokeColor(new Rgb(255, 255, 255))
          ->setStrokeWidth(3)
          ->drawEllipse(320, 240, 150, 75)
          ->output();

    $image->destroy();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
