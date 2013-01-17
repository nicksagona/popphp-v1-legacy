Pop PHP Framework
=================

Documentation : Web
-------------------

Il componente Web è una raccolta di web-based esigenze e funzionalità, tali sessioni di gestione, server, browser e cookie. Inoltre, include la funzionalità per la rilevazione di dispositivi mobili in modo che l'applicazione in grado di rispondere di conseguenza.

<pre>
use Pop\Web\Session;

$sess = Session::getInstance();
$sess->username = 'yourname';
print_r($sess);
print_r($_SESSION);

echo $sess->getId();
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
