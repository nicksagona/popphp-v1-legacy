Pop PHP Framework
=================

Documentation : Web
-------------------

Home

O componente Web é uma coleção de web-based necessidades e
funcionalidades, tais sessões de gestão, servidores, navegadores e
cookies. Além disso, inclui a funcionalidade de detecção de dispositivos
móveis para que sua aplicação possa responder em conformidade.

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
