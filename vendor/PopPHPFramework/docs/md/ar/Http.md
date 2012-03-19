Pop PHP Framework
=================

Documentation : Http
--------------------

المكون المتشعب يوفر وسيلة سهلة للاستخدام API لإدارة، والوصول والتلاعب في طلبات HTTP والاستجابات. يتم استخدامه في العديد من المكونات، ولكن معظم التقارب والتكامل مع المكون MVC لإدارة الطلبات والردود ضمن هذا المكون.

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
