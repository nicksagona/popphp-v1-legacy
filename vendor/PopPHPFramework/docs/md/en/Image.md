Pop PHP Framework
=================

Documentation : Image
---------------------

Home

The Image component provides a standardized API wrapper for the creation
and manipulation of images that leverages PHP's GD and Imagick
extensions, as well as the SVG image format. Within this component is a
feature-rich API for performing many different image-based functions.
And, since the API is standardized, if a project moves to a different
environment, it should degrade easily.

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
