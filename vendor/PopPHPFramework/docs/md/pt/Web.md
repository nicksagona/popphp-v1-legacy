Pop PHP Framework
=================

Documentation : Web
-------------------

Home

O componente Web Ã© uma coleÃ§Ã£o de web-based necessidades e
funcionalidades, tais sessÃµes de gestÃ£o, servidores, navegadores e
cookies. AlÃ©m disso, inclui a funcionalidade de detecÃ§Ã£o de
dispositivos mÃ³veis para que sua aplicaÃ§Ã£o possa responder em
conformidade.

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
