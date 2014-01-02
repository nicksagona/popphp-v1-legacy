Pop PHP Framework
=================

Documentation : Web
-------------------

Home

Webコンポーネントは、Webベースのニーズや機能性、このようなセッションの管理、サーバー、ブラウザとクッキーのコレクションです。また、それはあなたのアプリケーションがそれに応じて対応できるようにモバイルデバイスを検出するための機能が含まれています。

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
