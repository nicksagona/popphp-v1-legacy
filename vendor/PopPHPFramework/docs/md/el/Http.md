Pop PHP Framework
=================

Documentation : Http
--------------------

Home

Î— ÏƒÏ…Î½Î¹ÏƒÏ„ÏŽÏƒÎ± Http Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Î­Î½Î±Î½ ÎµÏ?ÎºÎ¿Î»Î¿ ÏƒÏ„Î·
Ï‡Ï?Î®ÏƒÎ· API Î³Î¹Î± Ï„Î· Î´Î¹Î±Ï‡ÎµÎ¯Ï?Î¹ÏƒÎ·, Ï„Î·Î½ Ï€Ï?ÏŒÏƒÎ²Î±ÏƒÎ·
ÎºÎ±Î¹ Ï„Î¿ Ï‡ÎµÎ¹Ï?Î¹ÏƒÎ¼ÏŒ Î±Î¹Ï„Î®ÏƒÎµÎ¹Ï‚ HTTP ÎºÎ±Î¹
Î±Ï€Î±Î½Ï„Î®ÏƒÎµÎ¹Ï‚. Î§Ï?Î·ÏƒÎ¹Î¼Î¿Ï€Î¿Î¹ÎµÎ¯Ï„Î±Î¹ ÏƒÎµ Ï€Î¿Î»Î»Î¬
ÏƒÏ„Î¿Î¹Ï‡ÎµÎ¯Î±, Î±Î»Î»Î¬ ÎµÎ¯Î½Î±Î¹ Ï€Î¹Î¿ ÏƒÏ„ÎµÎ½Î¬
ÏƒÏ…Î½Î´ÎµÎ´ÎµÎ¼Î­Î½Î· Î¼Îµ Ï„Î¿ MVC ÏƒÏ…Î½Î¹ÏƒÏ„ÏŽÏƒÎ± Î³Î¹Î± Ï„Î·
Î´Î¹Î±Ï‡ÎµÎ¯Ï?Î¹ÏƒÎ· Ï„Ï‰Î½ Î±Î¹Ï„Î®ÏƒÎµÏ‰Î½ ÎºÎ±Î¹ Ï„Ï‰Î½
Î±Ï€Î±Î½Ï„Î®ÏƒÎµÏ‰Î½ ÏƒÎµ Î±Ï…Ï„ÏŒ Ï„Î¿ ÏƒÏ„Î¿Î¹Ï‡ÎµÎ¯Î¿.

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
