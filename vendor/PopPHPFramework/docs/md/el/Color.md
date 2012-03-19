Pop PHP Framework
=================

Documentation : Color
---------------------

Η συνιστώσα του χρώματος είναι ένα χρήσιμο στοιχείο για τη διαχείριση και αξιοποίηση των αντικειμένων αξίας χρώμα. Παρέχει επίσης τη λειτουργικότητα για τη μετατροπή των τιμών των χρωμάτων σε άλλους χώρους χρώμα, για παράδειγμα, τη μετατροπή RGB σε CMYK.

<pre>
use Pop\Color\Color,
    Pop\Color\Rgb;

$color = new Color(new Rgb(112, 124, 228));
echo $color->cmyk->getCmyk(Color::STRING);
echo $color->lab->getLab(Color::STRING);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
