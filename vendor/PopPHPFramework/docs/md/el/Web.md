Pop PHP Framework
=================

Documentation : Web
-------------------

Home

Το στοιχείο Web είναι μια συλλογή από web-based ανάγκες και λειτουργίες,
όπως συνεδρίες διαχείρισης, διακομιστές, προγράμματα περιήγησης και τα
cookies. Επίσης, περιλαμβάνει τη λειτουργικότητα για την ανίχνευση
κινητών συσκευών, έτσι ώστε η αίτησή σας μπορεί να ανταποκριθεί ανάλογα.

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
