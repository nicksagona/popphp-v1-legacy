Pop PHP Framework
=================

Documentation : Image
---------------------

Home

يوفر عنصر صورة مجمع API موحدة لإنشاء والتلاعب في الصور التي تعزز GD PHP
وملحقات Imagick، فضلا عن شكل صورة SVG. ضمن هذا المكون هو API ميزة الغنية
لأداء العديد من مختلف الوظائف التي تعتمد على الصور. ومنذ API هو موحد،
إذا كان المشروع ينتقل إلى بيئة مختلفة، يجب أن تتحلل بسهولة

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
