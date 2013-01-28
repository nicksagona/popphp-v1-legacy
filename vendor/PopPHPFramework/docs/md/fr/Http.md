Pop PHP Framework
=================

Documentation : Http
--------------------

Home

La composante Http fournit un outil facile Ã utiliser l'API pour gÃ©rer,
accÃ©der et manipuler les requÃªtes et rÃ©ponses HTTP. Il est utilisÃ©
dans plusieurs composantes, mais elle est plus Ã©troitement intÃ©grÃ©
avec le composant MVC pour gÃ©rer les demandes et les rÃ©ponses dans ce
composant.

    use Pop\Http\Request,
        Pop\Http\Response;

    // Create a request object and access the data and information
    $request = new Request();
    echo $request->getRequestUri();
    if ($request->isPost()) {
        print_r($request->getPost());
    }

    // Create a response object and send
    $response = new Response();
    $response->setHeader('content-type', 'text/html')
             ->setBody('<html><body>This is some HTML.</body></html>')
             ->send();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
