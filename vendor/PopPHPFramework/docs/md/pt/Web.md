Pop PHP Framework
=================

Documentation : Web
-------------------

O componente Web é uma coleção de web baseados em necessidades e funcionalidades, tais sessões de gestão, servidores, navegadores e biscoitos. Além disso, inclui a funcionalidade de detecção de dispositivos móveis para que sua aplicação pode responder em conformidade.

<pre>
use Pop\Web\Session;

$sess = Session::getInstance();
$sess->username = 'yourname';
print_r($sess);
print_r($_SESSION);

echo $sess->getId();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
