Pop PHP Framework
=================

Documentation : Web
-------------------

Die Web-Komponente ist eine Sammlung von web-basierten Bedürfnisse und Funktionalität, wie Verwalten von Sitzungen, Server, Browser und Cookies. Außerdem enthält es die Funktionalität zur Erkennung mobiler Geräte so, dass Ihre Anwendung entsprechend reagieren können.

<pre>
use Pop\Web\Session;

$sess = Session::getInstance();
$sess->username = 'yourname';
print_r($sess);
print_r($_SESSION);

echo $sess->getId();
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
