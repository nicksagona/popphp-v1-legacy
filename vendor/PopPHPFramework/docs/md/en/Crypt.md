Pop PHP Framework
=================

Documentation : Crypt
-----------------------

Home

The Crypt component provides the ability to create hashes and verify values against those hashes. The Mcrypt class supports two-way encryption. The supported crypt types are:

    use Pop\Crypt\Bcrypt;

    $bc = new Bcrypt();
    $hash = $bc->create('12password34');

    echo $hash;

    if ($bc->verify('12password34', $hash)) {
        echo 'Verified!';
    } else {
        echo 'NOT Verified!';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
