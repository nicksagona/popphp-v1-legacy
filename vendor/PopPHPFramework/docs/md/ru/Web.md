Pop PHP Framework
=================

Documentation : Web
-------------------

Home

Веб-компонент представляет собой набор веб-потребностей и функций,
например управление сессиями, серверов, браузеров и печенье. Кроме того,
она включает в себя функциональность для обнаружения мобильных
устройств, так что ваше приложение может реагировать соответствующим
образом.

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
