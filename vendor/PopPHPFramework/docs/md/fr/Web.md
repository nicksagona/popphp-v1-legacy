Pop PHP Framework
=================

Documentation : Web
-------------------

Home

Le composant Web est un ensemble de besoins basÃ©s sur le web et les
fonctionnalitÃ©s, telles la gestion de sessions, les serveurs, les
navigateurs et les biscuits. En outre, il inclut la fonctionnalitÃ© de
dÃ©tection des appareils mobiles afin que votre application peut rÃ©agir
en consÃ©quence.

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
