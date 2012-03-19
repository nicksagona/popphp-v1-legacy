Pop PHP Framework
=================

Documentation : Color
---------------------

色成分は色の値オブジェクトを管理し、活用するのに便利なコンポーネントです。また、RGBからCMYKへの変換は、例えば、他のカラースペースにカラー値を変換する機能を提供します。


<pre>
use Pop\Color\Color,
    Pop\Color\Rgb;

$color = new Color(new Rgb(112, 124, 228));
echo $color->cmyk->getCmyk(Color::STRING);
echo $color->lab->getLab(Color::STRING);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
