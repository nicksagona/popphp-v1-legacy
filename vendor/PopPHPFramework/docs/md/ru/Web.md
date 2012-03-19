Pop PHP Framework
=================

Documentation : Web
-------------------

Веб-компонент представляет собой набор веб-потребности и возможности, например управление сессиями, серверы, браузеры и печенье. Кроме того, она включает в себя функциональность для обнаружения мобильных устройств, так что ваше приложение может реагировать соответствующим образом.

<pre>
use Pop\Web\Session;

$sess = Session::getInstance();
$sess->username = 'yourname';
print_r($sess);
print_r($_SESSION);

echo $sess->getId();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
