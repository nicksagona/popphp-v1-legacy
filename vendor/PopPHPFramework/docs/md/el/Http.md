Pop PHP Framework
=================

Documentation : Http
--------------------

Η συνιστώσα Http παρέχει έναν εύκολο στη χρήση API για τη διαχείριση, πρόσβαση και το χειρισμό αιτήσεων HTTP και απαντήσεις. Χρησιμοποιείται σε πολλά στοιχεία, αλλά είναι πιο στενά συνδεδεμένη με την MVC συστατικό για τη διαχείριση των αιτήσεων και των απαντήσεων σε αυτό το στοιχείο.

<pre>
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
         -send();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
