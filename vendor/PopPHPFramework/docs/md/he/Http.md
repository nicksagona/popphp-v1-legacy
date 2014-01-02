Pop PHP Framework
=================

Documentation : Http
--------------------

Home

מרכיב Http מספק קל לשימוש API לניהול, לגשת ולטפל בקשות ותגובות של HTTP.
הוא משמש במספר מרכיבים, אבל רוב חוזקה משולבת עם רכיב MVC לניהול בקשות
ותגובות בתוכו רכיב.

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
