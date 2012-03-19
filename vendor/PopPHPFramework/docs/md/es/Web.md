Pop PHP Framework
=================

Documentation : Web
-------------------

El componente de Web es una colección de web basados ​​en las necesidades y funcionalidad, como la gestión de sesiones, servidores, navegadores y galletas. Además, incluye la funcionalidad para la detección de dispositivos móviles de modo que su aplicación puede responder en consecuencia.

<pre>
use Pop\Web\Session;

$sess = Session::getInstance();
$sess->username = 'yourname';
print_r($sess);
print_r($_SESSION);

echo $sess->getId();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
