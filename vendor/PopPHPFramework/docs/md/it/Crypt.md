Pop PHP Framework
=================

Documentation : Crypt
-----------------------

Home

Il componente Cripta offre la possibilità di creare gli hash e verificare valori contro quei hash. La classe Mcrypt supporta la crittografia a due vie. I tipi cripta supportati sono:

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
