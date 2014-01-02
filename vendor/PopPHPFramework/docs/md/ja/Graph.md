Pop PHP Framework
=================

Documentation : Graph
---------------------

Home

グラフの構成要素には様々な形式のグラフを描画するためにSVGやPDF、画像などのグラフィックコンポーネントで構築されたのいずれかを利用できる堅牢なグラフ作成機能を可能にする。あなたは、線グラフ、棒グラフや円グラフを作成してレンダリングするグラフィック属性の広い配列を定義することができます。異なるグラフィック·コンポーネント間のAPIが標準化されているので、グラフを作成するための別のファイルや画像形式の間で交換するために非常に簡単です。

    use Pop\Color\Space\Rgb,
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


    $graph = new Graph(array(
        'filename' => 'graph.gif',
        'width'    => 640,
        'height'   => 480
    ));

    $graph->addFont('../assets/fonts/times.ttf')
          ->setFontColor(new Rgb(128, 128, 128))
          ->setFillColor(new Rgb(10, 125, 210))
          ->showY(true)
          ->showText(true)
          ->createLineGraph($data, $x, $y)
          ->output();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
