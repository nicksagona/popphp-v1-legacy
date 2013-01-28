Pop PHP Framework
=================

Documentation : Http
--------------------

Home

HTTPç»„ä»¶æ??ä¾›äº†ä¸€ä¸ªæ˜“äºŽä½¿ç”¨çš„APIæ?¥ç®¡ç?†ï¼Œè®¿é—®å’Œæ“?ä½œHTTPè¯·æ±‚å’Œå“?åº”ã€‚å®ƒè¢«ç”¨æ?¥åœ¨å‡
ä¸ªç»„æˆ?éƒ¨åˆ†ï¼Œä½†æœ€ç´§å¯†åœ°ç»“å?ˆåœ¨ä¸€èµ·çš„MVCç»„ä»¶ï¼Œè¯¥ç»„ä»¶å†…çš„ç®¡ç?†è¯·æ±‚å’Œå“?åº”ã€‚

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
