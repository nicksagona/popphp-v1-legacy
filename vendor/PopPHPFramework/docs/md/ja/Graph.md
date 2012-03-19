Pop PHP Framework
=================

Documentation : Graph
---------------------

グラフコンポーネントは、さまざまな形式でグラフを描画するSVGやPDF、画像などのグラフィックコンポーネントで構築されたのいずれかを利用することができる堅牢なグラフ機能が可能になります。あなたは、線グラフ、棒グラフと円グラフを作成し、レンダリングするグラフィック属性の広い配列を定義することができます。別のグラフィックコンポーネント間のAPIが標準化されているので、グラフを生成する別のファイルとイメージ形式の間で交換するために非常に簡単です。

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
