Pop PHP Framework
=================

Documentation : Graph
---------------------

العنصر الرسم البياني يسمح للحصول على وظائف الرسوم البيانية القوية التي يمكن أن تستخدم أي من المكونات التي بنيت في رسم مثل الصور، SVG وقوات الدفاع الشعبي لرسم الرسوم البيانية في مجموعة متنوعة من الأشكال. يمكنك تحديد مجموعة واسعة من سمات بيانية لخلق وتقديم الرسوم البيانية خط، الرسوم البيانية والرسوم البيانية الدائرية. منذ API بين مكونات الرسم المختلفة هو موحد، فإنه من السهل جدا لتبادل بين ملف وآخر وصيغ الصور التي لانتاج الرسم البياني.


<pre>
use Pop\Color\Rgb,
    Pop\Graph\Graph;

$x = array('1995', '2000', '2005', '2010', '2015');
$y = array('0M', '50M', '100M', '150M', '200M');

$data = array(
    array(1995, 0),
    array(1997, 35),
    array(1998, 25),
    array(2002, 100),
    array(2004, 84),
    array(2006, 98),
    array(2007, 76),
    array(2010, 122),
    array(2012, 175),
    array(2015, 162)
);

$graph = new Graph('graph.gif', 640, 480, Graph::IMAGICK);
//$graph = new Graph('graph.svg', 640, 480);
$graph->addFont('../assets/fonts/times.ttf')
      ->setFontColor(new Rgb(128, 128, 128))
      ->setFillColor(new Rgb(10, 125, 210))
      ->showY(true)
      ->showText(true)
      ->addLineGraph($data, $x, $y)
      ->output();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
