Pop PHP Framework
=================

Documentation : Web
-------------------

Home

Il componente Web è una raccolta di web-based esigenze e funzionalità,
tali sessioni di gestione, server, browser e biscotti. Inoltre, include
la funzionalità per il rilevamento di dispositivi mobili, in modo che
l'applicazione possa rispondere di conseguenza.

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
