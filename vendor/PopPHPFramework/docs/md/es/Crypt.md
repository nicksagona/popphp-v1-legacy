Pop PHP Framework
=================

Documentation : Crypt
-----------------------

Home

El componente de Cripta proporciona la capacidad de crear y verificar los valores hash contra esos valores hash. La clase Mcrypt compatible con el cifrado de dos vías. Los tipos cripta soportados son:

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
