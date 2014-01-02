Pop PHP Framework
=================

Documentation : Image
---------------------

Home

Η συνιστώσα εικόνας παρέχει μια τυποποιημένη περιτύλιγμα API για τη
δημιουργία και το χειρισμό των εικόνων που αξιοποιεί PHP GD και imagick
επεκτάσεις, καθώς και το SVG μορφή εικόνας. Μέσα σε αυτό το συστατικό
είναι ένα χαρακτηριστικό-πλούσια API για την εκτέλεση πολλών διαφορετική
εικόνα των λειτουργιών. Και, δεδομένου ότι το API είναι τυποποιημένη, αν
ένα έργο κινείται σε ένα διαφορετικό περιβάλλον, θα πρέπει να
υποβαθμίσει εύκολα.

    use Pop\Color\Space\Rgb,
        Pop\Image\Gd;

    $image = new Gd('new-image.jpg', 640, 480, new Rgb(255, 0, 0));
    $image->setFillColor(new Rgb(0, 0, 255))
          ->setStrokeColor(new Rgb(255, 255, 255))
          ->setStrokeWidth(3)
          ->drawEllipse(320, 240, 150, 75)
          ->output();

    $image->destroy();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
