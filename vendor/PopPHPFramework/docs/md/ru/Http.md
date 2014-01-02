Pop PHP Framework
=================

Documentation : Http
--------------------

Home

Http компонент обеспечивает легкий в использовании API для управления,
доступа и управления HTTP запросов и ответов. Он используется в
нескольких компонентов, но наиболее тесно интегрирован с Mvc компонента
для управления запросами и ответами в этом компоненте.

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
