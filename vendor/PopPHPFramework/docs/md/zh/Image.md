Pop PHP Framework
=================

Documentation : Image
---------------------

Home

图像组件提供了一个标准的API，用于创建和处理图像，充分利用了PHP的GD和imagick的扩展，以及SVG图像格式的包装。在这个组件是一个功能丰富的API，用于执行许多不同的基于图像的功能。而且，由于是标准化的API，如果一个项目移动到不同的环境中，它会逐渐降低容易。

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
