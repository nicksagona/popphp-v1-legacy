Pop PHP Framework
=================

Documentation : Web
-------------------

Home

El componente Web es una colección de web basados ​​en las necesidades y
funcionalidad, como la gestión de sesiones, servidores, navegadores y
cookies. Además, incluye la funcionalidad para la detección de
dispositivos móviles para que la aplicación pueda actuar en
consecuencia.

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
