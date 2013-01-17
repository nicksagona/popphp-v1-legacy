Pop PHP Framework
=================

Documentation : Http
--------------------

O componente HTTP fornece uma ferramenta easy-to-use API para gerenciar, acessar e manipular solicitações e respostas HTTP. É utilizado em vários componentes, mas é mais fortemente integrado com o componente Mvc de gestão dos pedidos e respostas dentro desse componente.

<pre>
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
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
