Pop PHP Framework
=================

Documentation : Web
-------------------

Home

Die Version Komponente stellt lediglich die MÃ¶glichkeit zu bestimmen,
welche Version von Pop Sie Strom haben, und was die neuesten zur
VerfÃ¼gung steht. Auch diese Komponente durch die CLI-Komponente
verwendet, um die AbhÃ¤ngigkeit-PrÃ¼fung durchzufÃ¼hren.

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
