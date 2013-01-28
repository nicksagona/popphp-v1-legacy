Pop PHP Framework
=================

Documentation : Http
--------------------

Home

Http ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¾Ð±ÐµÑ?Ð¿ÐµÑ‡Ð¸Ð²Ð°ÐµÑ‚ Ð»ÐµÐ³ÐºÐ¸Ð¹ Ð²
Ð¸Ñ?Ð¿Ð¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ð½Ð¸Ð¸ API Ð´Ð»Ñ? ÑƒÐ¿Ñ€Ð°Ð²Ð»ÐµÐ½Ð¸Ñ?,
Ð´Ð¾Ñ?Ñ‚ÑƒÐ¿Ð° Ð¸ ÑƒÐ¿Ñ€Ð°Ð²Ð»ÐµÐ½Ð¸Ñ? HTTP Ð·Ð°Ð¿Ñ€Ð¾Ñ?Ð¾Ð² Ð¸
Ð¾Ñ‚Ð²ÐµÑ‚Ð¾Ð². ÐžÐ½ Ð¸Ñ?Ð¿Ð¾Ð»ÑŒÐ·ÑƒÐµÑ‚Ñ?Ñ? Ð² Ð½ÐµÑ?ÐºÐ¾Ð»ÑŒÐºÐ¸Ñ…
ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð¾Ð², Ð½Ð¾ Ð½Ð°Ð¸Ð±Ð¾Ð»ÐµÐµ Ñ‚ÐµÑ?Ð½Ð¾
Ð¸Ð½Ñ‚ÐµÐ³Ñ€Ð¸Ñ€Ð¾Ð²Ð°Ð½ Ñ? Mvc ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð° Ð´Ð»Ñ?
ÑƒÐ¿Ñ€Ð°Ð²Ð»ÐµÐ½Ð¸Ñ? Ð·Ð°Ð¿Ñ€Ð¾Ñ?Ð°Ð¼Ð¸ Ð¸ Ð¾Ñ‚Ð²ÐµÑ‚Ð°Ð¼Ð¸ Ð² Ñ?Ñ‚Ð¾Ð¼
ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ðµ.

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
