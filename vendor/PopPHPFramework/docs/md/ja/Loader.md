Pop PHP Framework
=================

Documentation : Loader
----------------------

Loaderコンポーネントは、おそらくポップPHPフレームワークの最も基本的な、まだ最も重要なコンポーネントです。それはフレームワークのオートローディング機能を駆動するコンポーネントだし、独自のアプリケーションを簡単に独自のクラスをロードするためにオートローダを登録できます。これはsinglehandedlyこれらの古いのすべてを置き換え、すべての場所の上に持っていた記述が含まれます。今必要なのは、上部にある[bootstrap.phpの 'のいずれかが必要です。文で、あなたは行ってもいいです。デフォルトでは、ブートストラップファイルには、フレームワークのオートローダークラスに必要な参照が含まれていますし、それをロードします。ブートストラップファイル内では、簡単にそのようなオートローダを使用してアプリケーションの名前空間を登録したり、ロード時間を減少させるためにclassmapファイルをロードし、他の読み込み関数を実行することができます。


<pre>
// Instantiate the autoloader object
$autoloader = new Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

$autoloader->register('YourLib', '../vendor/YourLib/src');
$autoloader->loadClassMap('../vendor/YourLib/classmap.php');
</pre>

あなたが生成されたclassmapファイルを必要とする場合と、ローダー·コンポーネントは、簡単にだけでなく、あなたのためのclassmapファイルを生成する機能を備えています。


<pre>
// Generate a classmap file
Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
