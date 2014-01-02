Pop PHP Framework
=================

Documentation : Image
---------------------

Home

הרכיב מספק תמונת עטיפת API סטנדרטית ליצירה והמניפולציה של תמונות, הממנפת
את רחבות Imagick, כמו גם בפורמט SVG תמונת GD ושל PHP. בתוך רכיב זה הוא
API עשיר בתכונות לביצוע פונקציות המבוססות על תמונות רבות ושונות. ו, מאז
ה-API הוא טופל, אם פרויקט עובר לסביבה שונה, זה צריך להשפיל קלות.

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
