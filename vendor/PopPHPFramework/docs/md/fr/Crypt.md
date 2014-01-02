Pop PHP Framework
=================

Documentation : Crypt
-----------------------

Home

La composante Crypt offre la possibilité de créer des hashs et vérifier les valeurs par rapport à ces valeurs de hachage. La classe Mcrypt supporte le cryptage à double sens. Les types de crypte pris en charge sont:

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
