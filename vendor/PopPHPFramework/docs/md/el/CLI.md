Pop PHP Framework
=================

Documentation : Cli
-------------------

Η διασύνδεση γραμμής εντολών (CLI) είναι ένα πολύ χρήσιμο στοιχείο που σας επιτρέπει να εκτελέσετε μερικές χρήσιμες λειτουργίες, όπως:

* αξιολογήσει το σημερινό περιβάλλον για τις απαιτούμενες εξαρτήσεις
* εγκαταστήσετε ένα έργο από ένα αρχείο εγκατάστασης του έργου
* ορίσετε την προεπιλεγμένη γλώσσα της αίτησης
* δημιουργήσετε ένα χάρτη τάξη
* αναδιαμορφώσει ένα έργο που έχει μετακινηθεί
* ελέγξτε την τρέχουσα έκδοση κατά την τελευταία διαθέσιμη έκδοση

<pre>
script/pop --check                     // Check the current configuration for required dependencies
script/pop --help                      // Display this help
script/pop --install file.php          // Install a project based on the install file specified
script/pop --lang fr                   // Set the default language for the project
script/pop --map folder file.php       // Create a class map file from the source folder and save to the output file
script/pop --reconfig projectfolder    // Reconfigure the project based on the new location of the project
script/pop --show                      // Show project install instructions
script/pop --version                   // Display version of Pop PHP Framework and latest available
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
