Pop PHP Framework
=================

Documentation : Http
--------------------

Home

Der HTTP-Komponente bietet eine einfach zu bedienende API zu verwalten,
Zugriff und Manipulation HTTP Anfragen und Antworten. Es ist in mehrere
Komponenten verwendet, ist aber den meisten eng mit der MVC-Komponente
zur Verwaltung von Anfragen und Antworten in diesem Bauteil integriert.

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
