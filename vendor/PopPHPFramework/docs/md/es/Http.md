Pop PHP Framework
=================

Documentation : Http
--------------------

Home

El componente HTTP proporciona un fácil de usar API para gestionar,
acceder y manipular peticiones y respuestas HTTP. Se utiliza en varios
componentes, pero está más estrechamente integrado con el componente Mvc
para la gestión de las solicitudes y respuestas dentro de ese
componente.

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
