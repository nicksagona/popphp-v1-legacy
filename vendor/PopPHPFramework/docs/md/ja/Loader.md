Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

Loaderコンポーネントは、おそらくポップPHPフレームワークの最も基本的な、まだ最も重要なコンポーネントです。これはフレームワークのオートロード機能を駆動するコンポーネントだし、自分のアプリケーションを簡単に自分のクラスをロードするには、オートローダを登録できます。これはsinglehandedlyそれらの古いのすべてを置き換えるには、すべての場所で​​持っていた記述が含まれます。さて、あなたが必要なのは、トップに
"bootstrap.phpの
'のいずれかrequire文であり、あなたが行ってもいいです。デフォルトでは、ブートストラップファイルには、フレームワークのオートローダー·クラスに、必要な参照が含まれていますし、それをロードします。ブートストラップ·ファイル内では、簡単にそのようなオートローダーを使用してアプリケーションの名前空間を登録する、またはロード時間を短縮するclassmapファイルをロードするように他のロード機能を実行することができます。

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

あなたが生成classmapファイルが必要な場合と、ローダー·コンポーネントは簡単にだけでなく、あなたのためのclassmapファイルを生成する機能を持っています。

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
