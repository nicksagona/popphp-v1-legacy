Pop PHP Framework
=================

Documentation : Http
--------------------

Home

HTTPコンポーネントは、管理アクセスおよびHTTPのリクエストとレスポンスを操作するための使いやすいAPIを提供します。それはいくつかのコンポーネントで使用されていますが、ほとんどしっかりそのコンポーネント内の要求と応答を管理するためのMVCコンポーネントと統合されています。

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
