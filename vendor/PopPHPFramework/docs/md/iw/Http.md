Pop PHP Framework
=================

Documentation : Http
--------------------

Home

×ž×¨×›×™×‘ Http ×ž×¡×¤×§ ×§×œ ×œ×©×™×ž×•×© API ×œ× ×™×”×•×œ, ×œ×’×©×ª
×•×œ×˜×¤×œ ×‘×§×©×•×ª ×•×ª×’×•×‘×•×ª ×©×œ HTTP. ×”×•×? ×ž×©×ž×©
×‘×ž×¡×¤×¨ ×ž×¨×›×™×‘×™×?, ×?×‘×œ ×¨×•×‘ ×—×•×–×§×” ×ž×©×•×œ×‘×ª ×¢×?
×¨×›×™×‘ MVC ×œ× ×™×”×•×œ ×‘×§×©×•×ª ×•×ª×’×•×‘×•×ª ×‘×ª×•×›×• ×¨×›×™×‘.

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
