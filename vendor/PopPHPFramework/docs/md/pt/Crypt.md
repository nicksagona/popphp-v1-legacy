Pop PHP Framework
=================

Documentation : Crypt
-----------------------

Home

O componente Crypt fornece a capacidade de criar hashes e verificar os valores contra os hashes. A classe Mcrypt suporta criptografia de duas vias. Os tipos cripta suportados são:

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
