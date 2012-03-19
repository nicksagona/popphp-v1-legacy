Pop PHP Framework
=================

Documentation : Http
--------------------

Il componente Http fornisce un facile da usare API per gestire, accedere e modificare richieste e risposte HTTP. Viene utilizzato in diversi componenti, ma è più strettamente integrato con il componente Mvc di gestione di richieste e risposte all'interno di tale componente.


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

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
