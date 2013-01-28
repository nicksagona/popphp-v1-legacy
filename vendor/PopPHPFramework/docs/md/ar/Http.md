Pop PHP Framework
=================

Documentation : Http
--------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† Ø§Ù„Ù…ØªØ´Ø¹Ø¨ ÙŠÙˆÙ?Ø± ÙˆØ³ÙŠÙ„Ø© Ø³Ù‡Ù„Ø©
Ø§Ù„Ø§Ø³ØªØ®Ø¯Ø§Ù… Ù„API Ù„Ø¥Ø¯Ø§Ø±Ø© ÙˆØ§Ù„ÙˆØµÙˆÙ„ Ø¥Ù„ÙŠÙ‡Ø§
ÙˆØ§Ù„ØªÙ„Ø§Ø¹Ø¨ Ø·Ù„Ø¨Ø§Øª HTTP ÙˆØ§Ù„Ø§Ø³ØªØ¬Ø§Ø¨Ø§Øª. ÙŠØªÙ…
Ø§Ø³ØªØ®Ø¯Ø§Ù…Ù‡ Ù?ÙŠ Ø§Ù„Ø¹Ø¯ÙŠØ¯ Ù…Ù† Ø§Ù„Ù…ÙƒÙˆÙ†Ø§ØªØŒ ÙˆÙ„ÙƒÙ† Ù‡Ùˆ
Ø§Ù„Ø£ÙƒØ«Ø± Ø§Ù†Ø¯Ù…Ø§Ø¬Ø§ Ù…Ø¹ Ø§Ù„Ù…ÙƒÙˆÙ† MVC Ù„Ø¥Ø¯Ø§Ø±Ø©
Ø§Ù„Ø·Ù„Ø¨Ø§Øª ÙˆØ§Ù„Ø±Ø¯ÙˆØ¯ Ø¶Ù…Ù† Ù‡Ø°Ø§ Ø§Ù„Ù…ÙƒÙˆÙ†.

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
