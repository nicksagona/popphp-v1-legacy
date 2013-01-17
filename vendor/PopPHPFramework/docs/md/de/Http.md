Pop PHP Framework
=================

Documentation : Http
--------------------

Der HTTP-Komponente bietet eine einfach zu bedienende API zur Verwaltung, Zugriff und Manipulation von HTTP-Requests und-Responses. Es wird in mehreren Komponenten verwendet, wird jedoch am engsten mit dem MVC-Komponente zur Verwaltung von Anfragen und Antworten in diesem Bauteil integriert.

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
