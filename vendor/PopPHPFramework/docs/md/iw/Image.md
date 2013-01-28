Pop PHP Framework
=================

Documentation : Image
---------------------

Home

×”×¨×›×™×‘ ×ž×¡×¤×§ ×ª×ž×•× ×ª ×¢×˜×™×¤×ª API ×¡×˜× ×“×¨×˜×™×ª
×œ×™×¦×™×¨×” ×•×”×ž× ×™×¤×•×œ×¦×™×” ×©×œ ×ª×ž×•× ×•×ª, ×”×ž×ž× ×¤×ª ×?×ª
×¨×—×‘×•×ª Imagick, ×›×ž×• ×’×? ×‘×¤×•×¨×ž×˜ SVG ×ª×ž×•× ×ª GD ×•×©×œ
PHP. ×‘×ª×•×š ×¨×›×™×‘ ×–×” ×”×•×? API ×¢×©×™×¨ ×‘×ª×›×•× ×•×ª
×œ×‘×™×¦×•×¢ ×¤×•× ×§×¦×™×•×ª ×”×ž×‘×•×¡×¡×•×ª ×¢×œ ×ª×ž×•× ×•×ª
×¨×‘×•×ª ×•×©×•× ×•×ª. ×•, ×ž×?×– ×”-API ×”×•×? ×˜×•×¤×œ, ×?×?
×¤×¨×•×™×§×˜ ×¢×•×‘×¨ ×œ×¡×‘×™×‘×” ×©×•× ×”, ×–×” ×¦×¨×™×š ×œ×”×©×¤×™×œ
×§×œ×•×ª.

    use Pop\Color\Space\Rgb,
        Pop\Image\Gd;

    $image = new Gd('new-image.jpg', 640, 480, new Rgb(255, 0, 0));
    $image->setFillColor(new Rgb(0, 0, 255))
          ->setStrokeColor(new Rgb(255, 255, 255))
          ->setStrokeWidth(3)
          ->drawEllipse(320, 240, 150, 75)
          ->output();

    $image->destroy();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
