Pop PHP Framework
=================

Documentation : Image
---------------------

Η συνιστώσα της εικόνας παρέχει μια τυποποιημένη περιτύλιγμα API για τη δημιουργία και το χειρισμό των εικόνων που αξιοποιεί GD της PHP και imagick επεκτάσεις, καθώς και τη μορφή SVG εικόνας. Μέσα σε αυτό το στοιχείο είναι ένα πλούσιο σε χαρακτηριστικά API για την εκτέλεση πολλών διαφορετικών εικόνων με βάση τις λειτουργίες. Και, δεδομένου ότι η API είναι τυποποιημένη, αν ένα έργο κινείται σε ένα διαφορετικό περιβάλλον, θα πρέπει να υποβαθμίσει εύκολα.


<pre>
use Pop\Color\Rgb,
    Pop\Image\Gd;

$image = new Gd('new-image.jpg', 640, 480, new Rgb(255, 0, 0));
$image->setFillColor(new Rgb(0, 0, 255))
      ->setStrokeColor(new Rgb(255, 255, 255))
      ->setStrokeWidth(3)
      ->addEllipse(320, 240, 150, 75)
      ->output();

$image->destroy();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
