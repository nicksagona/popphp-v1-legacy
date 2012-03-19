Pop PHP Framework
=================

Documentation : Http
--------------------

HTTP组件提供了一个易于使用的API来管理，访问和操纵HTTP请求和响应。它被用来在几个组件，但最紧密集成MVC组件的管理要求，并在该组件的响应。


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
         -send();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
