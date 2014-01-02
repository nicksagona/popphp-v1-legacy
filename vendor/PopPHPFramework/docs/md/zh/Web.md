Pop PHP Framework
=================

Documentation : Web
-------------------

Home

Web组件是基于网络的需求和功能，例如管理会话，服务器，浏览器和cookie的集合。此外，它包括用于检测移动设备的功能，使您的应用程序可以作出相应的反应

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
