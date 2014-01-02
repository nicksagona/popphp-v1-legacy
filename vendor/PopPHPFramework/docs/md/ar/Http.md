Pop PHP Framework
=================

Documentation : Http
--------------------

Home

المكون المتشعب يوفر وسيلة سهلة الاستخدام لAPI لإدارة والوصول إليها
والتلاعب طلبات HTTP والاستجابات. يتم استخدامه في العديد من المكونات،
ولكن هو الأكثر اندماجا مع المكون MVC لإدارة الطلبات والردود ضمن هذا
المكون.

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
