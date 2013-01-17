Pop PHP Framework
=================

Documentation : Http
--------------------

מרכיב Http מספק קל לשימוש API לנהל, לגשת ולטפל בקשות HTTP ותגובות. הוא משמש מספר מרכיבים, אך היא משולבת באופן הדוק ביותר עם הרכיב MVC לניהול בקשות ותגובות בתוך רכיב.

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
