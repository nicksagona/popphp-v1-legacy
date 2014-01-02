Pop PHP Framework
=================

Documentation : Web
-------------------

Home

The Web component is a collection of web-based needs and functionality,
such managing sessions, servers, browsers and cookies. Also, it includes
the functionality for detecting mobile devices so that your application
can respond accordingly.

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
