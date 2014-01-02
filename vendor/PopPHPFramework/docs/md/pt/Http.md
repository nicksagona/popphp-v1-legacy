Pop PHP Framework
=================

Documentation : Http
--------------------

Home

O componente Http proporciona uma fácil de usar a API para gerenciar,
acessar e manipular solicitações HTTP e respostas. É usado em vários
componentes, mas é mais integrado com o componente Mvc de gestão dos
pedidos e respostas dentro desse componente.

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
