Pop PHP Framework
=================

Documentation : Web
-------------------

Home

El componente Web es una colecciÃ³n de web basados â€‹â€‹en las
necesidades y funcionalidad, como la gestiÃ³n de sesiones, servidores,
navegadores y cookies. AdemÃ¡s, incluye la funcionalidad para la
detecciÃ³n de dispositivos mÃ³viles para que la aplicaciÃ³n pueda actuar
en consecuencia.

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
