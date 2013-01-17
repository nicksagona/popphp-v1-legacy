Pop PHP Framework
=================

Documentation : Image
---------------------

רכיב תמונה מספקת מעטפת ה-API סטנדרטי ליצירת ומניפולציה של תמונות ממנף GD של PHP והרחבות Imagick, כמו גם פורמט תמונה SVG. בתוך מרכיב זה הוא ה-API עשיר בתכונות לביצוע רבים שונים התמונה מבוססי פונקציות. ו, מאז ה-API הוא טופל, אם הפרויקט עובר בסביבה שונה, זה צריך להשפיל בקלות.

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

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
