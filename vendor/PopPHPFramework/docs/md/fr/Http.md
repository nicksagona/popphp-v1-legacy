Pop PHP Framework
=================

Documentation : Http
--------------------

Home

La composante Http fournit un outil facile à utiliser l'API pour gérer,
accéder et manipuler les requêtes et réponses HTTP. Il est utilisé dans
plusieurs composantes, mais elle est plus étroitement intégré avec le
composant MVC pour gérer les demandes et les réponses dans ce composant.

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

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
