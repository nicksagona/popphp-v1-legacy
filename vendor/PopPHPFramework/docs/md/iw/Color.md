Pop PHP Framework
=================

Documentation : Color
---------------------

רכיב צבע הוא מרכיב שימושי לנהל ולנצל ערך אובייקטים צבעוניים. הוא גם מספק את הפונקציונליות כדי להמיר ערכי צבע מרחבי צבע אחרים, למשל, המרת RGB ל-CMYK.

<pre>
use Pop\Color\Color,
    Pop\Color\Rgb;

$color = new Color(new Rgb(112, 124, 228));
echo $color->cmyk->getCmyk(Color::STRING);
echo $color->lab->getLab(Color::STRING);
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
