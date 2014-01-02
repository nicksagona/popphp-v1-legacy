Pop PHP Framework
=================

Documentation : Http
--------------------

Home

HTTP组件提供了一个易于使用的API来管理，访问和操作HTTP请求和响应。它被用来在几个组成部分，但最紧密地结合在一起的MVC组件，该组件内的管理请求和响应。

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
