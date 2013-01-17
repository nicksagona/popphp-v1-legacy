Pop PHP Framework
=================

Documentation : Image
---------------------

Imageコンポーネントは、PHPのGDとImagickは拡張子と同様に、SVG画像形式を利用して画像の作成と操作のための標準的なAPIのラッパーを提供します。このコンポーネント内の多くの異なったイメージベースの機能を実行するための機能豊富なAPIです。プロジェクトは、異なる環境に移動すると、APIが標準化されているので、それは容易に分解する必要があります。

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
