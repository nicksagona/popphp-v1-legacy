Pop PHP Framework
=================

Documentation : Http
--------------------

Le composant HTTP fournit un outil facile à utiliser l'API pour gérer, accéder et de manipuler les requêtes HTTP et les réponses. Il est utilisé dans plusieurs composantes, mais il est plus étroitement intégré avec le composant MVC pour gérer les demandes et les réponses au sein de cette composante.

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
