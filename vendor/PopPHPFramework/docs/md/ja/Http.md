Pop PHP Framework
=================

Documentation : Http
--------------------

Home

HTTPã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?ç®¡ç?†ã‚¢ã‚¯ã‚»ã‚¹ã?Šã‚ˆã?³HTTPã?®ãƒªã‚¯ã‚¨ã‚¹ãƒˆã?¨ãƒ¬ã‚¹ãƒ?ãƒ³ã‚¹ã‚’æ“?ä½œã?™ã‚‹ã?Ÿã‚?ã?®ä½¿ã?„ã‚„ã?™ã?„APIã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚ã??ã‚Œã?¯ã?„ã??ã?¤ã?‹ã?®ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?§ä½¿ç”¨ã?•ã‚Œã?¦ã?„ã?¾ã?™ã?Œã€?ã?»ã?¨ã‚“ã?©ã?—ã?£ã?‹ã‚Šã??ã?®ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆå†…ã?®è¦?æ±‚ã?¨å¿œç­”ã‚’ç®¡ç?†ã?™ã‚‹ã?Ÿã‚?ã?®MVCã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¨çµ±å?ˆã?•ã‚Œã?¦ã?„ã?¾ã?™ã€‚

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
