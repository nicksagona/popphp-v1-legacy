Pop PHP Framework
=================

Documentation : Curl
--------------------

Home

Die Curl-Komponente stellt lediglich eine objektorientierte API-Wrapper,
um cURL Erweiterung von PHP.

    use Pop\Curl\Curl;

    $curl = new Curl('http://pop.localhost/examples/curl/curl-process.php');
    $curl->setPost(true);
    $curl->setFields(array(
        'name'  => 'Bubba',
        'email' => 'bubba@hotmail.com'
    ));

    $curl->execute();

    echo $curl->getBody();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
