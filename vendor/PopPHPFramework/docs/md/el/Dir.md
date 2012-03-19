Pop PHP Framework
=================

Documentation : Dir
-------------------

Οι Dir στοιχεία είναι χρήσιμη για την εισαγωγή αρχείων σε έναν κατάλογο, αναδρομικά ή μη-αναδρομικά. Επίσης, υπάρχει μια μέθοδος για να αδειάσει εντελώς έναν κατάλογο, αλλά ότι θα πρέπει προφανώς να χρησιμοποιείται με προσοχή.

<pre>
use Pop\Dir\Dir;

// Create the Dir object
$dir = new Dir('../mydir);

// Loop through the files in the directory
foreach ($dir->files as $file) {
    echo $file;
}
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
