Pop PHP Framework
=================

Documentation : Web
-------------------

Web组件是基于网络的需求和功能，例如管理会话，服务器，浏览器和Cookie的集合。此外，它还包括检测移动设备的功能，使您的应用程序可以作出相应的反应。

<pre>
use Pop\Web\Session;

$sess = Session::getInstance();
$sess->username = 'yourname';
print_r($sess);
print_r($_SESSION);

echo $sess->getId();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
