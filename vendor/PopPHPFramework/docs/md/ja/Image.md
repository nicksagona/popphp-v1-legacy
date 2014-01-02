Pop PHP Framework
=================

Documentation : Image
---------------------

Home

Imageコンポーネントは、PHPのGDとImagickを拡張子だけでなく、SVG画像フォーマットを活用した画像の作成と操作のための標準化されたAPIのラッパーを提供します。このコンポーネント内でさまざまな画像ベースの機能を実行するための機能豊富なAPIです。プロジェクトが別の環境に移動した場合と、APIが標準化されているので、それは簡単に分解する必要があります。

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
