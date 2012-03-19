Pop PHP Framework
=================

Documentation : Color
---------------------

عنصر اللون هو عنصر مفيدة لإدارة واستخدام الكائنات قيمة اللون. كما يوفر وظيفة لتحويل القيم إلى اللون لون المساحات الأخرى، على سبيل المثال، وتحويل RGB إلى CMYK.


<pre>
use Pop\Color\Color,
    Pop\Color\Rgb;

$color = new Color(new Rgb(112, 124, 228));
echo $color->cmyk->getCmyk(Color::STRING);
echo $color->lab->getLab(Color::STRING);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
