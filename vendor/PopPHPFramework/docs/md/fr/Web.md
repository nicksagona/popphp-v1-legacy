Pop PHP Framework
=================

Documentation : Web
-------------------

Le composant Web est une collection de web-base des besoins et des fonctionnalités, telles la gestion de sessions, les serveurs, les navigateurs et les cookies. En outre, il inclut la fonctionnalité de détection des appareils mobiles afin que votre application peut réagir en conséquence.

<pre>
use Pop\Web\Session;

$sess = Session::getInstance();
$sess->username = 'yourname';
print_r($sess);
print_r($_SESSION);

echo $sess->getId();
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
