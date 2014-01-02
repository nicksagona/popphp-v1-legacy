Pop PHP Framework
=================

Documentation : Crypt
-----------------------

Home

Die Krypta Komponente bietet die Möglichkeit, Hashes erstellen und zu überprüfen Werte gegen die Hashes. Die Mcrypt Klasse unterstützt Zwei-Wege-Verschlüsselung. Die unterstützten Krypta Typen sind:

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
